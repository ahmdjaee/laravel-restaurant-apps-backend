<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    use ApiResponse;
    public function create(EventRequest $request): JsonResponse
    {
        $data = $request->validated();
        $request->validate([
            'image' => ['required', 'image', 'max:5120']
        ]);

        $data['image'] = $request->file('image')->store('events');
        $event = Event::create($data);

        return $this->apiResponse(new EventResource($event), 'Event created successfully', 201);
    }

    public function update(EventRequest $request, int $id): JsonResponse
    {
        $event = Event::find($id);
        if (!$event) {
            $this->validationRequest('Event id does not exist', 404);
        }

        $data = $request->validated();
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['required', 'image', 'max:5120']
            ]);
            $event->image != null && Storage::delete($event->image);
            $data['image'] = $request->file('image')->store('events');
        }

        $event->update($data);
        return $this->apiResponse(new EventResource($event), 'Event updated successfully', 200);
    }

    public function delete(int $id): JsonResponse
    {
        $event = Event::find($id);

        if ($event == null) {
            $this->validationRequest('Event id does not exist', 404);
        }

        $event->delete();

        return $this->apiResponse(true, 'Event deleted successfully', 200);;
    }

    public function getAll(): ResourceCollection
    {
        $event = Event::all();
        return EventResource::collection($event);
    }
}
