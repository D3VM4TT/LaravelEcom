<?php

namespace App\Http\Controllers;

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

        // TODO: This should be a DTO or something
        $item = [
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'color' => $request->color,
        ];

        $this->cartService->addOrUpdateItemInCart($item);

        return back()->with('success', 'Item added to cart');
    }
}
