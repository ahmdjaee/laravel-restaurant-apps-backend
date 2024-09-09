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

        // Make sure the cart already exists or create a new one if it doesn't.
        $cart = $user->cart ?? $user->cart()->create(['user_id' => $user->id]);

        // Check if the item is already in the cart?
        $availableCartItem = $cart->cart_items()->where('menu_id', $data['menu_id'])->first();

        if ($availableCartItem) {
            $availableCartItem->update(['quantity' => $availableCartItem->quantity + $data['quantity']]);
            $cartItem = $availableCartItem;
        } else {
            $cartItem = $cart->cart_items()->create($data);
        }

        return $this->apiResponse(new CartItemResource($cartItem), 'Successfully added item to cart', 201);;
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
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


    public function delete(int $id): JsonResponse
    {
        $user = Auth::user();

        $cartItem = CartItem::where('cart_id', $user->cart->id)->find($id);

        if ($cartItem == null) {
            $this->validationRequest('Cart Item id does not exists', 404);
        }

        $cartItem->delete();

        return $this->apiResponse(new CartItemResource($cartItem), 'Cart Item deleted successfully', 200);
    }

    public function getAll(): JsonResponse
    {
        $user = Auth::user();

        if (!$user->cart) {
            return $this->apiResponse([], 'Cart is empty', 200);
        }

        // Combine total quantity and total price calculations in one query
        $totalData = CartItem::query()
            ->join('menus', 'menus.id', '=', 'cart_items.menu_id')
            ->where('cart_items.cart_id', $user->cart->id)
            ->selectRaw('SUM(cart_items.quantity) as total_quantity, SUM(menus.price * cart_items.quantity) as total_price')
            ->first();

        $totalQuantity = $totalData->total_quantity;
        $totalPrice = $totalData->total_price;

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
