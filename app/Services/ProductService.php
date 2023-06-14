<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;

class ProductService
{

    public function updateProduct(Product $product, ProductUpdateRequest $productUpdateRequest) {
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

    public function uploadImage($file): ?string
    {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('img/products'), $filename);
        return $filename;
    }
}
