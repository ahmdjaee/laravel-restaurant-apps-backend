<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\User;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ValidationRequest;
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::query()->where('email', $data['email'])->count() > 0) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'email' => 'Email already exists'
                ]
            ], 400));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);

        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->where('email', '=', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            $this->validationRequest('Wrong email or password', 400);
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        $cart = Cart::query()->where('user_id', '=', $user->id)->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->save();
        }

        return (new UserResource($user))->response();
    }


    // public function update(UserUpdateRequest $request): UserResource
    // {
    //     $data = $request->validated();
    //     $user = Auth::user();

    //     if (isset($data['name'])) {
    //         $user->name = $data['name'];
    //     }

    //     if (isset($data['password'])) {
    //         $user->password = Hash::make($data['password']);
    //     }

    //     $user->save();

    //     return new UserResource($user);
    // }

    public function current(): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->token = null;

        $user->save();

        return response()->json([
            'data' => true
        ], 200);
    }
}
