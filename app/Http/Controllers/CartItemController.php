<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Utils\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return $this->apiResponse(new CartItemResource($cartItem), 'Successfully added item to cart', 201);;
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

        $cartItem = CartItem::where('cart_id', $user->cart->id)->find($id);

        if ($cartItem == null) {
            $this->validationRequest('Cart Item id does not exists', 404);
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return $this->apiResponse(new CartItemResource($cartItem), 'Cart Item updated successfully', 200);
    }


    public function delete(int $id)
    {
        $user = Auth::user();

        $cartItem = CartItem::where('cart_id', $user->cart->id)->find($id);

        if ($cartItem == null) {
            $this->validationRequest('Cart Item id does not exists', 404);
        }

        $cartItem->forceDelete();

        return $this->apiResponse(new CartItemResource($cartItem), 'Cart Item deleted successfully', 200);
    }

    public function getAll(): JsonResponse
    {
        $user = Auth::user();

        if (!$user->cart) {
            return $this->apiResponse([], 'Cart is empty', 200);
        }

        // Gabungkan penghitungan total quantity dan total price dalam satu query
        $totalData = CartItem::query()
            ->join('menus', 'menus.id', '=', 'cart_items.menu_id')
            ->where('cart_items.cart_id', $user->cart->id)
            ->selectRaw('SUM(cart_items.quantity) as total_quantity, SUM(menus.price * cart_items.quantity) as total_price')
            ->first();

        $totalQuantity = $totalData->total_quantity;
        $totalPrice = $totalData->total_price;

        // Eager load menus untuk mengurangi query tambahan
        $cartItems = CartItem::with('menu')
            ->where('cart_id', $user->cart->id)
            ->get();

        return $this->apiResponse([
            'id' => $user->cart->id,
            'items' => CartItemResource::collection($cartItems),
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice
        ]);
    }
}
