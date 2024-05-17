<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request): Response
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

        return response([
            'data' => [
                'id' => $category->id,
                'name' => $category->name
            ]
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $collection = Category::all(['id', 'name']);

        if ($collection->count() < 1 || $collection == null) {
            $this->validationRequest('No Records Found', 404);
        }

        return response(['data' => $collection])->json()->setStatusCode(200);
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
            $this->validationRequest('Category id does not exist', 404);
        }

        return response()->json(['data' => $category])->setStatusCode(200);
        ;
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
