<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Exceptions\HttpResponseException;
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

    public function cancel()
    {
    }

    public function update(int $id, ReservationRequest $request): ReservationResource
    {
        $user = Auth::user();
        $data = $request->validated();
        $find = Reservation::find($id);

        if (!$find) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'id' => 'Cannot found reservation id'
                ]
            ], 400));
        }

        $reservation = new Reservation($data);
        $reservation->user_id = $user->id;

        return new ReservationResource($reservation);
    }
}
