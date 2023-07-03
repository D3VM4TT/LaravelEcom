<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class PageController extends Controller
{


    public function __construct(private CartService $cartService)
    {
    }

    public function index()
    {
        // TODO: Get the most recent products from the database
        $featured_products = Product::orderBy('created_at', 'desc')->take(8)->get();

        return view('pages/home', compact('featured_products'));
    }

    public function cart()
    {
        $cart = $this->cartService->getCart();

        if (empty($cart->getItems())) {
            return redirect()->route('home');
        }

        return view('pages/cart', compact('cart'));
    }

    public function wishlist()
    {
        return view('pages/wishlist');
    }

    public function profile()
    {
        return view('pages/profile');
    }


    public function product($id)
    {
        $product = Product::find($id);

        return view('pages/product', compact('product'));
    }

}
