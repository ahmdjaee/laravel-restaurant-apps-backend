<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponse;

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'unique:categories,name'],
            'image' => ['required', 'image', 'max:5120']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $validator->validate();
        $data['image'] = $request->file('image')->store('categories');
        $category = Category::create($data);

        return $this->apiResponse(
            [
                'id' => $category->id,
                'name' => $category->name,
                'image' => url()->route('image', ['path' => $category->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
                'image_large' => url()->route('image', ['path' => $category->image, 'w' => 800, 'h' => 800, 'fit' => 'crop']),
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
            'name' => ['required', 'max:100']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $validator->validate();
        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'max:5120']]);
            $category->image != null && Storage::delete($category->image);
            $data['image'] = $request->file('image')->store('categories');
        }
        $category->update($data);

        return $this->apiResponse(
            [
                'id' => $category->id,
                'name' => $category->name,
                'image' => url()->route('image', ['path' => $category->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
                'image_large' => url()->route('image', ['path' => $category->image, 'w' => 800, 'h' => 800, 'fit' => 'crop']),
            ],
            'Category updated successfully',
            200
        );
    }

    public function getAll(): JsonResponse
    {
        $collection = Category::all(['id', 'name', 'image']);
        $data = $collection->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'image' => url()->route('image', ['path' => $category->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
                'image_large' => url()->route('image', ['path' => $category->image, 'w' => 800, 'h' => 800, 'fit' => 'crop']),
            ];
        });
        return $this->apiResponse($data);;
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

        return response()->json(['data' => [
            'id' => $category->id,
            'name' => $category->name,
            'image' => url()->route('image', ['path' => $category->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
            'image_large' => url()->route('image', ['path' => $category->image, 'w' => 800, 'h' => 800, 'fit' => 'crop']),
        ]])->setStatusCode(200);
    }
}
