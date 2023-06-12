<?php

namespace Tests\Unit;

use App\Models\User;
use App\Permissions\Permissions;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Role $role;

    protected function setUp(): void

    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $this->seed(RoleAndPermissionSeeder::class);

        $this->role = Role::findByName('Admin');

        $this->user->assignRole('Admin');

    }
    public function test_index_method_returns_view(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.products.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.product.index');
    }

    public function test_access_to_index_method_is_denied_if_user_does_not_have_permission(): void
    {
        $this->role->revokePermissionTo(Permissions::PRODUCT_PERMISSIONS);
        $response = $this->actingAs($this->user)->get(route('admin.products.index'));
        $response->assertStatus(403);
    }



}
