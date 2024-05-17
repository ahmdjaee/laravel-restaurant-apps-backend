<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Http\Resources\TableCollection;
use App\Http\Resources\TableResource;
use App\Models\Table;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TableController extends Controller
{
    public function create(TableRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (Table::where('no', $data['no'])->count() > 0) {
            $this->validationRequest('No table already exists', 400);
        }

        $table = new Table($data);
        $table->save();

        return (new TableResource($table))->response()->setStatusCode(201);
    }

    public function getAll(): JsonResource
    {
        $collection = Table::all();

        if ($collection->count() < 1 || $collection == null) {
            $this->validationRequest('No Records Found', 404);
        }

        return TableResource::collection($collection);
    }

    public function delete(int $id): JsonResponse
    {
        $table = Table::find($id);

        if ($table == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        $table->forceDelete();

        return response()->json(['data' => true])->setStatusCode(200);
    }

    public function update(int $id, TableRequest $request)
    {
        $table = Table::find($id);
        $data = $request->validated();

        if ($table == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        $table->update($data);

        return new TableResource($table);
    }

    public function get(int $id): TableResource
    {
        $table = Table::find($id);

        if ($table == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        return new TableResource($table);
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
