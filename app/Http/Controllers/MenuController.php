<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    use ApiResponse;
    public function create(MenuRequest $request): JsonResponse
    {
        $data = $request->validated();

        $menu = Menu::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'description' => $data['description'],
            'stock' => $data['stock'],
            'image' => $request->file('image')->store('menus'),
        ]);

        return $this->apiResponse(new MenuResource($menu), 'Menu created successfully', 201);
    }

    public function update(int $id, MenuRequest $request): JsonResponse
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

        return $this->apiResponse(new MenuResource($menu), 'Menu updated successfully', 200);;
    }

    public function getAll(): MenuCollection
    {
        $collection = Menu::with('category')->get();
        return new MenuCollection($collection);
    }


    public function delete(int $id): JsonResponse
    {
        $menu = Menu::find($id);
        if ($menu == null || !$menu) {
            $this->validationRequest('Menu id does not exist', 404);
        }

        $menu->delete();

        return $this->apiResponse(true, 'Menu deleted successfully', 200);
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
