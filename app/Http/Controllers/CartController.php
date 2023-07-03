<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function __construct(private CartService $cartService)
    {
    }

    public function addItemToCart(Request $request, Product $product)
    {

        $item = Item::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'color_id' => 11 // $request->color,
        ]);


        $this->cartService->addItemToCartSession($item);

        return back()->with('success', 'Item added to cart');
    }

    public function removeItemFromCart(Request $request, Item $item)
    {
        $this->cartService->removeItemFromCartSession($item);

        return back()->with('success', 'Item removed from cart');
    }
}
