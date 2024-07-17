<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableController extends Controller
{
    use ApiResponse;
    public function create(TableRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (Table::where('no', $data['no'])->count() > 0) {
            $this->validationRequest('Number table already exists', 400);
        }

        $table = new Table($data);
        $table->save();

        return $this->apiResponse(new TableResource($table), 'Table created successfully', 201);
    }

    public function getAll(Request $request): JsonResource
    {
        $collection = new Table();

        $status = $request->query('status', null);

        if ($status) {
            $collection = $collection->where('status', $status);
        }

        $collection = $collection->get();

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

        return $this->apiResponse(true, 'Table deleted successfully', 200);
    }

    public function update(int $id, TableRequest $request)
    {
        $table = Table::find($id);
        $data = $request->validated();

        if ($table == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        $table->update($data);

        return $this->apiResponse(new TableResource($table), 'Table updated successfully', 200);
    }

    public function get(int $id): TableResource
    {
        $table = Table::find($id);

        if ($table == null) {
            $this->validationRequest('Table id does not exist', 404);
        }

        return new TableResource($table);
    }
}
