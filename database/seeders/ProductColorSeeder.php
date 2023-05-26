<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::paginate(5);
        $colors = Color::paginate(5);

        foreach ($products as $product) {
            foreach ($colors as $color) {
                ProductColor::firstOrCreate([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                ]);
            }
        }

    }
}
