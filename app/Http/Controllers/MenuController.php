<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    use ValidationRequest;
    public function create(MenuRequest $request): JsonResponse
    {
        if (!Gate::allows('is-admin')) {
            $this->validationRequest('This action is not allowed.', 403);
        }

        $data = $request->validated();

        $menu = Menu::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'description' => $data['description'],
            'stock' => $data['stock'],
            'image' => $request->file('image')->store('menus'),
        ]);

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

        if ($request->hasFile('image')) {
            $menu->image != null && Storage::delete($menu->image);
            $menu->update([
                'image' => $request->file('image')->store('menus'),
            ]);
        }

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

    public function get(int $id): MenuResource
    {
        $menu = Menu::find($id);

        if ($menu == null) {
            $this->validationRequest('Menu id does not exist', 404);
        }

        return new MenuResource($menu);
    }
}
