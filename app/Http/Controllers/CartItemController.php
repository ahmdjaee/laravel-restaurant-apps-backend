<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Utils\Trait\ValidationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{
    use ValidationRequest;
    public function store(CartItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();

        $cart = $user->cart;

        $cartItem = new CartItem($data);
        $cartItem->cart_id = $cart->id;

        // retrieve data if it already exists?
        $availableCartItem = CartItem::where('cart_id', $cart->id)->where('menu_id', $data['menu_id'])->first();

        if ($availableCartItem != null) {
            $cartItem->id = $availableCartItem->id;
            $cartItem->quantity = $availableCartItem->quantity + $data['quantity'];

            $availableCartItem->update(['quantity' => $cartItem->quantity]);
        } else {
            $cartItem->save();
        }

        return (new CartItemResource($cartItem))->response()->setStatusCode(200);
    }

    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validate();
        $user = Auth::user();

        $card = Cart::where('user_id', $user->id)->first();
        $cartItem = CartItem::where('cart_id', $card->id)->find($id);

        if ($cartItem == null) {
            $this->validationRequest('Cart Item id does not exists', 404);
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return (new CartItemResource($cartItem))->response()->setStatusCode(200);
    }


    public function delete(int $id)
    {
        $user = Auth::user();

        $card = Cart::where('user_id', $user->id)->first();

        $cartItem = CartItem::where('cart_id', $card->id)->find($id);

        if ($cartItem == null) {
            $this->validationRequest('Cart Item id does not exists', 404);
        }

        $cartItem->forceDelete();

        return response(['data' => true])->setStatusCode(200);
    }

    public function getAll() : ResourceCollection
    {
        $user = Auth::user();

        // Subquery untuk menghitung total_quantity
        $totalQuantity = CartItem::where('cart_id', $user->cart->id)
            ->select(DB::raw('SUM(quantity)'))
            ->pluck('SUM(quantity)')->first();

        // Query utama untuk mendapatkan data cart items dengan kolom tambahan total_quantity
        $cartItems = CartItem::where('cart_id', $user->cart->id)
            ->select('*', DB::raw($totalQuantity . ' as total_quantity'))
            ->get();

        if ($cartItems->isEmpty()) {
            $this->validationRequest('No Records Found', 404);
        }

        return CartItemResource::collection($cartItems);
    }
}
