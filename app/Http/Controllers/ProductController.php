<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        // set the permissions for this controller
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource
     */
    public function index(Request $request)
    {
        $data = Product::latest()->paginate(5);
        return view('admin.pages.product.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);

    }

    /**
     * Display the specified resource
     */
    public function show(Product $product)
    {
        return view('admin.pages.products.show', compact('product'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $contentTitle = 'Product Management: Create Product';

        return view('admin.pages.product.form', compact('categories', 'colors', 'contentTitle'));
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

        $productData = $request->all();

        if ($request->file('image')) {
            $productData['image'] = FileHelper::uploadImage($request->file('image'), 'public/Product');
        }

        $product = Product::create($productData);

        $productCategory = Category::find($request['category']);

        $product->category()->associate($productCategory);

        $productColors = $productData['colors'];

        foreach ($productColors as $color) {
            $product->colors()->attach($color);
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');

    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(Product $product)
    {

        $categories = Category::all();
        $colors = Color::all();
        $contentTitle = 'Product Management: Update Product';

        return view('admin.pages.product.form', compact('product', 'categories', 'colors', 'contentTitle' ));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'colors' => 'required',
        ]);

        $productData = $request->except(['image']);

        if ($request->file('image')) {
            $productData['image'] = FileHelper::uploadImage($request->file('image'), 'public/Product');
        }

        $product->update($productData);

        $currentProductCategory = $product->category()->pluck('id')->first();
        if ($currentProductCategory != $productData['category']) {
            $productCategory = Category::find($productData['category']);
            $product->category()->associate($productCategory);
        }

        $currentProductColors = $product->colors()->pluck('id')->toArray();
        if ($currentProductColors != $productData['colors']) {
            $product->colors()->detach($currentProductColors);
            $product->colors()->attach($productData['colors']);
        }

        $product->save();

        return redirect()->route('admin.products.index')
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
