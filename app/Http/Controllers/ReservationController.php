<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
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

    public function validationRequest(string $message, int $statusCode)
    {
        throw new HttpResponseException(response([
            'errors' => [
                'message' => [
                    $message
                ]
            ]
        ], $statusCode));
    }
}
