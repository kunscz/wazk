<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run()
    {
        // User::factory(10)->create();
        
        // Create permissions
        $permissions = [
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // Create menu items
        $dashboard = Menu::create([
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'order' => 1,
        ]);
        $dashboard->roles()->attach($adminRole);

        $userManagement = Menu::create([
            'name' => 'User Management',
            'icon' => 'fas fa-users',
            'order' => 2,
        ]);
        $userManagement->roles()->attach($adminRole);

        Menu::create([
            'name' => 'Users',
            'route' => 'users.index',
            'parent_id' => $userManagement->id,
            'permission_id' => Permission::where('name', 'user-list')->first()->id,
            'order' => 1,
        ])->roles()->attach($adminRole);

        Menu::create([
            'name' => 'Roles',
            'route' => 'roles.index',
            'parent_id' => $userManagement->id,
            'permission_id' => Permission::where('name', 'role-list')->first()->id,
            'order' => 2,
        ])->roles()->attach($adminRole);
    }
}
