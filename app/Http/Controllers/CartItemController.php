<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{
    use ApiResponse;
    public function store(CartItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();

        $cart = Cart::query()->where('user_id', '=', $user->id)->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->save();
        }

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

        return $this->apiResponse(new CartItemResource($cartItem), 'Item added successfully', 201);;
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

        return $this->apiResponse(new CartItemResource($cartItem), 'Cart Item updated successfully', 200);
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

        return $this->apiResponse(new CartItemResource($cartItem), 'Cart Item deleted successfully', 200);
    }

    public function getAll(): ResourceCollection
    {
        $user = Auth::user();

        if (!$user->cart) {
            return CartItemResource::collection([]);
        }
        
        // Subquery untuk menghitung total_quantity
        $totalQuantity = CartItem::where('cart_id', $user->cart->id)
            ->select(DB::raw('SUM(quantity)'))
            ->pluck('SUM(quantity)')->first();

        // Query utama untuk mendapatkan data cart items dengan kolom tambahan total_quantity
        $cartItems = CartItem::where('cart_id', $user->cart->id)
            ->select('*', DB::raw($totalQuantity . ' as total_quantity'))
            ->get();

        return CartItemResource::collection($cartItems);
    }
}
