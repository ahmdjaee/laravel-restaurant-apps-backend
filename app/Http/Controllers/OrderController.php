<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ValidationRequest;
    public function order(OrderRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        // $findOrder = Order::whereHas('reservation', function (Builder $query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->first();

        // $order = new Order($data);

        // if (!$findOrder) {
        //     $order->user_id = $user->id;
        //     $order->save();
        // }else{
        //     $order = $findOrder; 
        // }

        // $items = [];

        // foreach ($data['items'] as $item) {
        //     $items[] = [
        //         'order_id' => $order->id,
        //         'menu_id' => $item['menu_id'],
        //         'price' => $item['price'],
        //         'quantity' => $item['quantity'],
        //     ];
        // }

        // OrderItem::where('order_id', $order->id)->delete();

        // OrderItem::insert($items);

        // return new OrderResource($order);

        $order = Order::firstOrCreate(
            ['user_id' => $user->id],
            $data
        );
    
        $items = array_map(function ($item) use ($order) {
            return [
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ];
        }, $data['items']);
    
        DB::transaction(function () use ($order, $items) {
            OrderItem::where('order_id', $order->id)->delete();
            OrderItem::insert($items);
        }); 
    
        return new OrderResource($order);
    }

    // public function getAll()
    // {
    //     $user = Auth::user();

    //     $orders = Order::join('reservations', 'orders.reservation_id', '=', 'reservations.id')
    //         ->join('users', 'reservations.user_id', '=', 'users.id')
    //         ->where('reservations.user_id', $user->id)
    //         ->select('orders.*')
    //         ->get();

    //     if ($orders->count() == 0) {
    //         $this->validationRequest('No Records Found', 404);
    //     }

    //     return OrderResource::collection($orders);
    // }
}
