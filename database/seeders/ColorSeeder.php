<?php

namespace Database\Seeders;

use Database\Factories\ColorFactory;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ColorFactory::times(10)->create();
    }
}
