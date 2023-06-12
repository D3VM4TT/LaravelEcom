<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryFactory::times(10)->create();

        $categories = Category::paginate(5);
        $products = Product::paginate(5);

        // TODO: the below is not working properly & needs to be fixed
        foreach ($products as $product) {
            foreach ($categories as $category) {
                $product->category()->associate($category);
                $product->save();
            }
        }
    }
}
