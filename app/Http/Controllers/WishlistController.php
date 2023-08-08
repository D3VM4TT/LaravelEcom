<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request, Product $product)
    {
        $user = $request->user();
        $user->wishlist()->attach($product->id);
        return back()->with('success_message', 'Product added to wishlist successfully');
    }


    public function removeFromWishlist(Request $request, Product $product)
    {
        $user = $request->user();
        $user->wishlist()->detach($product->id);
        return back()->with('success_message', 'Product removed from wishlist successfully');
    }
}
