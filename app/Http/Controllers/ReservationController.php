<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ValidationRequest;
    public function reserve(ReservationRequest $request): ReservationResource
    {
        $user = Auth::user();
        $data = $request->validated();

        $reservation = new Reservation($data);
        $reservation->user_id = $user->id;
        $reservation->save();

        return new ReservationResource($reservation);
    }

    public function update(int $id, ReservationRequest $request): ReservationResource
    {
        $data = $request->validated();
        $reservation = Reservation::find($id);

        if (!$reservation) {
            $this->validationRequest('Reservation id does not exist', 404);
        }

        $reservation->update($data);

        return new ReservationResource($reservation);
    }

    public function cancel(int $id): JsonResponse
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            $this->validationRequest('Reservation id does not exist', 404);
        }

        $reservation->forceDelete();

        return response()->json(['data' => true])->setStatusCode(200);
    }

    public function get(): ReservationResource
    {
        $user = Auth::user();
        $reservation = Reservation::where('user_id', $user->id)->first();

        if (!$reservation) {
            $this->validationRequest('No data found', 404);
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
}
