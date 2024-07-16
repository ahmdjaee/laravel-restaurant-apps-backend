<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function create(EventRequest $request): JsonResponse
    {
        $data = $request->validated();

        $event = new Event($data);
        $event->image = $request->file('image')->store('events');
        $event->save();

        return (new EventResource($event))->response()->setStatusCode(201);
    }

    public function update()
    {
    }

    public function delete(int $id): JsonResponse
    {
        if (!Gate::allows('is-admin')) {
            $this->validationRequest('This action is not allowed.', 403);
        }
        
        $event = Event::find($id);

        if ($event == null) {
            $this->validationRequest('Event id does not exist', 404);
        }

        $event->delete();

        return response()->json(['data' => true])->setStatusCode(200);
    }

    public function getAll(): ResourceCollection
    {
        $event = Event::all();
        return EventResource::collection($event);
    }
}
