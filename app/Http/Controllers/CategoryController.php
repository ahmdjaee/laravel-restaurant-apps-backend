<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            new CategoryResource($category),
            'Category created successfully',
            201
        );
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $category = Category::findOrFail($id);
    
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', Rule::unique('categories')->ignore($category->id)],
            'image' => ['nullable', 'image', 'max:5120']
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $data = $validator->validated();
    
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories');
        }
    
        $category->update($data);
    
        return $this->apiResponse(
            new CategoryResource($category),
            'Category updated successfully',
            200
        );
    }
    

    public function getAll(): JsonResponse
    {
        $collection = Category::all(['id', 'name', 'image']);
        return $this->apiResponse(CategoryResource::collection($collection));
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

        return $this->apiResponse(new CategoryResource($category));
    }
}
