<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Utils\Trait\ApiResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponse;

    public function create(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::query()->where('email', $data['email'])->exists()) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'email' => 'Email already exists'
                ]
            ], 400));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);

        if ($request->input('is_admin')) {
            $user->is_admin = $request->input('is_admin');
        }

        $user->save();

        return $this->apiResponse(new UserResource($user), 'Create user has been successful', 201);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $user = User::find($id);

        $user->update($request->safe()->only(['name']));

        if (isset($data['email']) && $user->email != $data['email'] && $user->where('email', $data['email'])->doesntExist()) {
            $user->update(['email' => $data['email']]);
        }

        if (isset($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }


        if ($request->input('is_admin')) {
            $user->update(['is_admin' => $request->input('is_admin')]);
        }

        if ($request->hasFile('photo')) {
            $user->photo != null && Storage::delete($user->photo);
            $user->update([
                'photo' => $request->file('photo')->store('users'),
            ]);
        }

        return $this->apiResponse(new UserResource($user), 'User updated successfully', 200);
    }

    public function getAll(Request $request): ResourceCollection
    {
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);
        $search = $request->query('search', null);
        $latest = $request->query('latest', null);

        $query = User::query();

        if ($search) {
            $query->where(function (Builder $builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($latest) {
            $query->where('is_admin', 0)
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('id', 'desc');
        }

        $collection = $query->paginate(perPage: $perPage, page: $page)
            ->onEachSide(1)
            ->withQueryString();

        return UserResource::collection($collection);
    }

    public function delete(int $id): JsonResponse
    {
        $user = User::find($id);

        if ($user == null || !$user) {
            $this->validationRequest('User id does not exist', 404);
        }

        if ($user->id == Auth::user()->id) {
            $this->validationRequest('You cannot delete yourself', 400);
        }

        $user->delete();

        return $this->apiResponse(true, 'User deleted successfully', 200);
    }

    public function summary(): JsonResponse
    {
        $totalUser = User::query()->count();

        return $this->apiResponse([
            'total' => $totalUser
        ]);
    }
}
