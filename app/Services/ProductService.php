<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductService
{

    public function updateProduct(Product $product, ProductRequest $productUpdateRequest) {
        $productData = $productUpdateRequest->except(['image']);

        if ($productUpdateRequest->file('image')) {
            $productData['image'] = $this->uploadImage($productUpdateRequest->file('image'));
        }

        $product->update($productData);

        $this->updateCategory($product, $productData['category']);
        $this->updateColors($product, $productData['colors']);

        $product->save();
    }

    public function updateCategory(Product $product, $categoryId): void
    {
        $currentProductCategory = $product->category()->pluck('id')->first();

        if ($currentProductCategory != $categoryId) {
            $productCategory = Category::find($categoryId);
            $product->category()->associate($productCategory);
        }
    }

    public function updateColors(Product $product, array $colorIds): void
    {
        $currentProductColors = $product->colors()->pluck('id')->toArray();

        if ($currentProductColors != $colorIds) {
            $product->colors()->detach($currentProductColors);
            $product->colors()->attach($colorIds);
        }
    }

    private function uploadImage($file): ?string
    {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('img/products'), $filename);
        return $filename;
    }

    public function createProduct(ProductRequest $request)
    {
        $productData = $request->all();

        if ($request->file('image')) {
            $productData['image'] = $this->uploadImage($request->file('image'));
        }

        $product = Product::create($productData);

        $productCategory = Category::find($request['category']);

        $product->category()->associate($productCategory);

        $productColors = $productData['colors'];

        foreach ($productColors as $color) {
            $product->colors()->attach($color);
        }

        $product->save();

        return $product;
    }
}
