<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    use ApiResponse;

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::query()->where('email', $data['email'])->exists()) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'email' => 'Email already exists'
                ]
            ], 400));
        }

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return $this->apiResponse(new UserResource($user), 'Register has been successful', 201);;
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!$token = auth()->attempt($data)) {
            $this->validationRequest('Wrong email or password', 400);
        }

        $user = auth()->user();

        return $this->apiResponse([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (int) auth()->factory()->getTTL()
        ], 'Login has been successful', 200);
    }
    
    public function loginAdmin(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->where('email', '=', $data['email'])->where('is_admin', '=', 1)->first();

        if (!($token = auth()->setTTL(3600)->attempt($data)) || !$user) {
            $this->validationRequest('Wrong email or password', 400);
        }

        return $this->apiResponse([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (int) auth()->factory()->getTTL()
        ], 'Login has been successful', 200);
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = Auth::user();

        $user->update($request->safe()->only(['name']));

        if (isset($data['email']) && $user->email != $data['email']) {
            $user->update(['email' => $data['email']]);
        }

        if (isset($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        if ($request->hasFile('photo')) {
            $user->photo != null && Storage::delete($user->photo);
            $user->update([
                'photo' => $request->file('photo')->store('users'),
            ]);
        }

        return $this->apiResponse(new UserResource($user), 'User updated successfully', 200);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return $this->apiResponse(true, 'User logged out successfully', 200);
    }

    public function current(): UserResource
    {
        return new UserResource(auth()->user());
    }

}
