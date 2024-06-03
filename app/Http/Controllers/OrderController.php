<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(OrderRequest $request)
    {
        $data = $request->validated();

        $order = new Order($data);
        
        return new OrderResource($order);
    }


}
