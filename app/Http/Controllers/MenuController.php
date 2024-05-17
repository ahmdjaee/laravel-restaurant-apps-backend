<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    use ValidationRequest;
    public function create(MenuRequest $request): JsonResponse
    {
        $data = $request->validated();

        $menu = new Menu($data);
        $menu->save();

        return (new MenuResource($menu))->response()->setStatusCode(201);
    }

    public function update()
    {
    }

    public function getAll()
    {
        $collection = Menu::all();

        if ($collection->count() < 1 || $collection == null) {
            $this->validationRequest('No Records Found', 404);
        }

        return new MenuCollection($collection);
    }

    public function search()
    {

    }

    public function delete()
    {
    }

    public function get()
    {
    }
}
