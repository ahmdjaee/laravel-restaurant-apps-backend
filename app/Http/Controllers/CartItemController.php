<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\CartItem;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function store(CartItemRequest $request): CartItemResource
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

        return new CartItemResource($cartItem);
    }

    public function update(int $id, CartItemRequest $request)
    {

    }


    public function delete()
    {
    }

    public function getAll(): ResourceCollection
    {
        $user = Auth::user();
        $cartItem = CartItem::with('menu')->where('cart_id', $user->cart->id)->get();

        if ($cartItem->isEmpty()) {
            $this->validationRequest('No Records Found', 404);
        }

        return CartItemResource::collection($cartItem);
    }
}
