<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        // TODO: Get the most recent products from the database
        $featured_products = Product::orderBy('created_at', 'desc')->take(8)->get();

        return view('pages/home', compact('featured_products'));
    }

    public function cart()
    {
        return view('pages/cart');
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
