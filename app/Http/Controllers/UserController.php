<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\User;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        return (new UserResource($user))->response();
    }
    public function loginAdmin(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->where('email', '=', $data['email'])->where('is_admin', '=', 1)->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            $this->validationRequest('Wrong email or password', 400);
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return (new UserResource($user))->response();
    }


    public function update(UserUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        /** @var User $user */
        $user = Auth::user();
        $user->update($request->safe()->only(['name', 'email']));

        if (isset($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        if ($request->hasFile('photo')) {
            $user->photo != null && Storage::delete($user->photo);
            $user->update([
                'photo' => $request->file('photo')->store('users'),
            ]);
        }

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function current(): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->token = null;

        $user->save();

        return response()->json([
            'data' => true
        ], 200);
    }

    public function getAll(Request $request): ResourceCollection
    {
        if (!Gate::allows('is-admin')) {
            $this->validationRequest('This action is not allowed.', 403);
        }

        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);

        $collection = User::query()->where(function (Builder $builder) use ($request) {
            $search = $request->query('search', null);

            if ($search) {
                $builder->orWhere('name', 'like', "%{$search}%");
                $builder->orWhere('email', 'like', "%{$search}%");
            }
        });

        /** @var User $collection */
        $collection = $collection->paginate(perPage: $perPage, page: $page)->onEachSide(1)->withQueryString();

        // if ($collection->count() < 1 || $collection == null) {
        //     $this->validationRequest('No Records Found', 404);
        // }

        return UserResource::collection($collection);
    }

    public function delete(int $id)
    {

        if (!Gate::allows('is-admin')) {
            $this->validationRequest('This action is not allowed.', 403);
        }

        $user = User::find($id);

        if ($user == null || !$user) {
            $this->validationRequest('User id does not exist', 404);
        }

        $user->delete();

        return response()->json([
            'data' => true
        ], 200);
    }
}
