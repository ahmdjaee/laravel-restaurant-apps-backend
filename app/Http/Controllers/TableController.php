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
    public function insert(TableRequest $request): JsonResponse
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

        return new TableCollection($collection);
    }

    public function delete(int $id): JsonResponse
    {
        $result = Table::find($id);

        if ($result == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        $result->forceDelete();

        return response()->json(['data' => true])->setStatusCode(200);
    }

    public function update(int $id, TableRequest $request)
    {
        $result = Table::find($id);
        $data = $request->validated();

        if ($result == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        $table = new Table($data);
        $table->save();

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
