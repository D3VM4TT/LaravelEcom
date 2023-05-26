<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        // set the permissions for this controller
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource
     */
    public function index(Request $request)
    {
        $products = Product::latest()->paginate(5);
        return view('admin.pages.product.index', compact('products'))
            ->with('i', ($request->input('page', 1) - 1) * 5);

    }

    /**
     * Display the specified resource
     */
    public function show(Product $product)
    {
       return view('products.show', compact('product'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        // TODO: Create the new product entity

        $product = Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully');

    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit()
    {
        return view('products.edit');
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, Product $product)
    {
       $this->validate($request, [
           'name' => 'required',
           'description' => 'required',
       ]);

      $product->update($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }


}
