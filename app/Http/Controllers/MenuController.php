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
        $request->validate(['image' => ['required', 'image', 'max:5120'],]);

        $data['image'] = $request->file('image')->store('menus');

        $menu = Menu::create($data);
        return $this->apiResponse(new MenuResource($menu), 'Menu created successfully', 201);
    }

    public function update(int $id, MenuRequest $request): JsonResponse
    {
        $menu = Menu::find($id);
        if ($menu == null || !$menu) {
            $this->validationRequest('Menu id does not exist', 404);
        }
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'max:5120']]);
            $menu->image != null && Storage::delete($menu->image);
            $data['image'] = $request->file('image')->store('menus');
        }
        
        $menu->update($data);
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
