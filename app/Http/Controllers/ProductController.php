<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Helpers\MessageHelper;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{

    private const ENTITY = 'Product';

    public function __construct(private ProductService $productService)
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
    public function store(ProductRequest $request): RedirectResponse
    {

        $this->productService->createProduct($request);

        return redirect()->route('admin.products.index')
            ->with('success', MessageHelper::createdSuccessMessage(self::ENTITY));

    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(Product $product)
    {

        $categories = Category::all();
        $colors = Color::all();
        $contentTitle = 'Product Management: Update Product';

        return view('admin.pages.product.form', compact('product', 'categories', 'colors', 'contentTitle'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProduct($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', MessageHelper::updatedSuccessMessage(self::ENTITY));
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', MessageHelper::deletedSuccessMessage(self::ENTITY));
    }


}
