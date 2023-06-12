<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ProductSeeder::class,
            ColorSeeder::class,
            ProductColorSeeder::class,
            CategorySeeder::class,
            RoleAndPermissionSeeder::class,
            CreateAdminUserSeeder::class,
            ProductSeeder::class
        ]);
    }
}
