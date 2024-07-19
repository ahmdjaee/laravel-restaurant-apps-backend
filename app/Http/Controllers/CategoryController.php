<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponse;

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'unique:categories,name']
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validate();
        $category = Category::create($data);

        return $this->apiResponse(
            [
                'id' => $category->id,
                'name' => $category->name
            ],
            'Category created successfully',
            201
        );
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $category = Category::find($id);
        if ($category == null) {
            $this->validationRequest('Category id does not exist', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'unique:categories,name']
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validate();
        $category->update($data);

        return $this->apiResponse(
            [
                'id' => $category->id,
                'name' => $category->name
            ],
            'Category created successfully',
            200
        );
    }

    public function getAll(): JsonResponse
    {
        $collection = Category::all(['id', 'name']);
        return response()->json(['data' => $collection])->setStatusCode(200);
    }

    public function delete(int $id): JsonResponse
    {
        $category = Category::find($id);

        if ($category == null) {
            $this->validationRequest('Category id does not exist', 404);
        }

        $category->delete();

        return $this->apiResponse(true, 'Category deleted successfully', 200);;
    }

    public function get(int $id): JsonResponse
    {
        $category = Category::find($id, ['id', 'name']);

        if ($category == null) {
            $this->validationRequest('Category id does not exist', 404);
        }

        return response()->json(['data' => $category])->setStatusCode(200);
    }
}
