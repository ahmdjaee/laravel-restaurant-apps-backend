<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    use ValidationRequest;
    public function create(MenuRequest $request): JsonResponse
    {
        $data = $request->validated();

        $menu = Menu::create($data);

        return (new MenuResource($menu))->response()->setStatusCode(201);
    }

    public function update(int $id, MenuRequest $request): MenuResource
    {
        $menu = Menu::find($id);
        if ($menu == null || !$menu) {
            $this->validationRequest('Menu id does not exist', 404);
        }
        $data = $request->validated();
        $menu->update($data);

        return new MenuResource($menu);
    }

    public function getAll(): MenuCollection
    {
        $collection = Menu::with('category')->get();

        if ($collection->count() < 1 || $collection == null) {
            $this->validationRequest('No Records Found', 404);
        }

        return new MenuCollection($collection);
    }

    public function search(Request $request)
    {
        $search = $request->query('search', null);
        $name = $request->query('name', null);
    }

    public function delete(int $id): Response
    {
        if (!Gate::allows('delete-menu')) {
            $this->validationRequest('This action is not allowed.', 403);
        }
        $menu = Menu::find($id);
        if ($menu == null || !$menu) {
            $this->validationRequest('Menu id does not exist', 404);
        }

        $menu->forceDelete();

        return response(['data' => true])->setStatusCode(200);
    }

    public function get()
    {
    }
}
