<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Utils\Trait\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    use ApiResponse;

    public function create(MenuRequest $request): JsonResponse
    {
        $data = $request->validated();
        $request->validate(['image' => ['required', 'image', 'max:5120'],]);

        $data['image'] = $request->file('image')->store('menus');
        if (isset($data['tags'])) $data['tags'] = implode(',', $data['tags']);
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
        if (isset($data['tags'])) $data['tags'] = implode(',', $data['tags']);
        else $data['tags'] = null;

        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'max:5120']]);
            $menu->image != null && Storage::delete($menu->image);
            $data['image'] = $request->file('image')->store('menus');
        }

        $menu->update($data);
        return $this->apiResponse(new MenuResource($menu), 'Menu updated successfully', 200);;
    }

    public function getAll(Request $request)
    {
        $tags = $request->query('tags', null);

        $collection = Menu::query()->where(function (Builder $query) use ($tags) {
            if ($tags) {
                $query->where('tags', 'like', "%$tags%");
            }
        })->get();

        return MenuResource::collection($collection);
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

    public function summary(): JsonResponse
    {
        $totalMenu = Menu::count();
        return $this->apiResponse(['total' => $totalMenu]);
    }
}
