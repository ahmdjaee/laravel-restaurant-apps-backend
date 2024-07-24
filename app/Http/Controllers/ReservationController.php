<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ApiResponse;
    public function reserve(ReservationRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        if (Reservation::where('user_id', $user->id)->where('status', 'pending')->count() > 0) {
            $this->validationRequest("Complete the order or cancel the reservation to make another reservation.", 400);
        }

        $data['user_id'] = $user->id;
        $reservation = Reservation::create($data);

        return $this->apiResponse(new ReservationResource($reservation), 'Reservation created successfully', 201);;
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

    public function getAllAdmin(): JsonResponse
    {
        $reservations = Reservation::all();
        return (ReservationResource::collection($reservations))->response();
    }
}
