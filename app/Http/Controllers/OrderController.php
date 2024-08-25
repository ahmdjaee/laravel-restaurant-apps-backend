<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Utils\Enum\StatusOrder;
use App\Utils\Enum\StatusReservation;
use App\Utils\Trait\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    use ApiResponse;
    public function order(OrderRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $data['user_id'] = $user->id;
        $order = Order::create($data);

        $items = array_map(function ($item) use ($order) {
            return [
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ];
        }, $data['items']);

        $total_payment = 0;

        foreach ($items as $item) {
            $total_payment += $item['price'] * $item['quantity'];
        }

        DB::transaction(function () use ($user, $items, $total_payment, $order) {

            $order->update(['total_payment' => $total_payment]);
            OrderItem::insert($items);

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $total_payment
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email
                ]
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->token = $snapToken;
        });
        return $this->apiResponse(new OrderResource($order), 'Order created successfully', 201);
    }

    // public function success(string $id)
    // {
    //     try {
    //         //code...
    //         $order = Order::find($id);
    //         DB::transaction(function () use ($order) {
    //             Reservation::query()->update(['status' => StatusReservation::confirmed]);
    //             $order->update(['status' => StatusOrder::paid]);
    //         });
    //     } catch (\Throwable) {
    //     }
    // }

    public function get(string $id): OrderResource
    {
        $order = Order::find($id);
        return new OrderResource($order);
    }
    public function getAll(): ResourceCollection
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)->get();
        return OrderResource::collection($orders);
    }

    public function getAllAdmin(Request $request): ResourceCollection
    {
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);

        $collection = Order::query()->with('user')->where(function (Builder $builder) use ($request) {
            $search = $request->query('search', null);

            if ($search) {
                $builder->orWhere('id', 'like', "%{$search}%");
                $builder->orWhere('status', 'like', "%{$search}%");

                $builder->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            }
        });


        $collection = $collection->paginate(perPage: $perPage, page: $page)->onEachSide(1)->withQueryString();

        return OrderResource::collection($collection);
    }
}
