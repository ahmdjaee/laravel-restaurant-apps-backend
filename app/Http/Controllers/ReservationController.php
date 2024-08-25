<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Utils\Trait\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ApiResponse;
    public function reserve(ReservationRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        $reservation = Reservation::where('user_id', $user->id)->where('status', 'pending')->first();

        if ($reservation) {
            $reservation->update($data);
        } else {
            $reservation = Reservation::create($data);
        }

        return $this->apiResponse(
            new ReservationResource($reservation),
            'Reservation created successfully',
            201
        );;
    }

    public function update(int $id, ReservationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $reservation = Reservation::find($id);

        if (!$reservation) {
            $this->validationRequest('Reservation id does not exist', 404);
        }

        $reservation->update($data);

        return $this->apiResponse(new ReservationResource($reservation), 'Reservation updated successfully', 200);;
    }

    public function cancel(int $id): JsonResponse
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            $this->validationRequest('Reservation id does not exist', 404);
        }

        $reservation->delete();

        return $this->apiResponse(true, 'Reservation canceled successfully', 200);
    }

    public function get(): ReservationResource
    {
        $user = Auth::user();

        $reservation = Reservation::where('user_id', $user->id)->where('status', 'pending')->first();

        if (!$reservation) {
            $this->validationRequest('Reservation not found', 404);
        }

        return new ReservationResource($reservation);
    }

    public function getAll(Request $request): JsonResponse
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id);

        $status = $request->get('status');

        if ($status) {
            $reservations = $reservations->where('status', $status)->get();
        } else {
            $reservations = $reservations->get();
        }

        return (ReservationResource::collection($reservations))->response();
    }

    public function getAllAdmin(Request $request): ResourceCollection
    {
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);

        $collection = Reservation::query()->with('user')->where(function (Builder $builder) use ($request) {
            $search = $request->query('search', null);

            if ($search) {
                $builder->orWhere('id', 'like', "%{$search}%");
                $builder->orWhere('status', 'like', "%{$search}%");

                $builder->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            }
        });


        $collection = $collection->paginate(perPage: $perPage, page: $page)->onEachSide(1)->withQueryString();

        return ReservationResource::collection($collection);
    }
}
