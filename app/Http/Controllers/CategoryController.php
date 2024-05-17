<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'max:100', 'unique:categories,name']
            ]);
        } catch (ValidationException $exception) {
            return response([
                'errors' => $exception->errors(),
            ], 400);
        }

        $category = new Category($data);
        $category->save();

        return response([
            'data' => [
                'id' => $category->id,
                'name' => $category->name
            ]
        ], 201);
    }

    public function update(int $id, Request $request)
    {
        try {
            $category = Category::find($id);
            if ($category == null) {
                $this->validationRequest('Category id does not exist', 404);
            }

            $data = $request->validate([
                'name' => ['required', 'max:100']
            ]);
            $category->update($data);

            return response([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ], 200);
        } catch (ValidationException $exception) {
            return response([
                'errors' => $exception->errors(),
            ], 400);
        }
    }

    public function getAll(): CategoryCollection
    {
        $collection = Category::all(['id', 'name']);

        if ($collection->count() < 1 || $collection == null) {
            $this->validationRequest('No Records Found', 404);
        }

        return new CategoryCollection($collection);
    }

    public function delete(int $id): JsonResponse
    {
        $category = Category::find($id);

        if ($category == null) {
            $this->validationRequest('Category id does not exist', 404);
        }

        $category->forceDelete();

        return response()->json(['data' => true])->setStatusCode(200);
    }

    public function get(int $id): JsonResponse
    {
        $category = Category::find($id, ['id', 'name']);

        if ($category == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        return response()->json(['data' => $category])->setStatusCode(200);;
    }

    public function validationRequest(string $message, int $statusCode)
    {
        throw new HttpResponseException(response([
            'errors' => [
                'message' => [
                    $message
                ]
            ]
        ], $statusCode));
    }
}
