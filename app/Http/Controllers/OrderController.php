<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    use ValidationRequest;
    public function order(OrderRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // $order = Order::firstOrCreate(
        //     ['user_id' => $user->id],
        //     $data
        // );

        $order = new Order($data);
        $order->user_id = $user->id;
        $order->save();

        $items = array_map(function ($item) use ($order) {
            return [
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ];
        }, $data['items']);

        DB::transaction(function () use ($order, $items, $user) {
            OrderItem::where('order_id', $order->id)->delete();
            OrderItem::insert($items);

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_payment
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email
                ]
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->token = $snapToken;
        });

        return new OrderResource($order);
    }

    public function getAll()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)->get();

        // $orders = Order::join('reservations', 'orders.reservation_id', '=', 'reservations.id')
        //     ->join('users', 'reservations.user_id', '=', 'users.id')
        //     ->where('reservations.user_id', $user->id)
        //     ->select('orders.*')
        //     ->get();

        if ($orders->count() == 0) {
            $this->validationRequest('No Records Found', 404);
        }

        return OrderResource::collection($orders);
    }
}
