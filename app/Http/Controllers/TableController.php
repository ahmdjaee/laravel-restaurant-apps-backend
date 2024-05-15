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
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'No table already exists'
                    ]
                ]
            ], 404));
        }

        $table = new Table($data);
        $table->save();

        return (new TableResource($table))->response()->setStatusCode(201);
    }

    public function getAll(): JsonResource
    {
        $collection = Table::all();

        if ($collection->count() < 1 || $collection == null) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        'No Records Found'
                    ]
                ]
            ], 404));
        }

        return new TableCollection($collection);
    }
}
