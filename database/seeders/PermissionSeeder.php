<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // 'guard_name' =>  'admin'


        Permission::create(['name' => 'manage users', 'guard_name' =>  'web']);



        // ..
        Permission::create(['name' => 'manage roles', 'guard_name' =>  'web']);
        Permission::create(['name' => 'create roles', 'guard_name' =>  'web']);
        Permission::create(['name' => 'display roles', 'guard_name' =>  'web']);
        Permission::create(['name' => 'edit roles', 'guard_name' =>  'web']);
        Permission::create(['name' => 'delete roles', 'guard_name' =>  'web']);

        // ..
        Permission::create(['name' => 'manage user', 'guard_name' =>  'web']);
        Permission::create(['name' => 'create user', 'guard_name' =>  'web']);
        Permission::create(['name' => 'display user', 'guard_name' =>  'web']);
        Permission::create(['name' => 'edit user', 'guard_name' =>  'web']);
        Permission::create(['name' => 'delete user', 'guard_name' =>  'web']);


        Permission::create(['name' => 'manage product', 'guard_name' =>  'web']);
        Permission::create(['name' => 'create product', 'guard_name' =>  'web']);
        Permission::create(['name' => 'display product', 'guard_name' =>  'web']);
        Permission::create(['name' => 'edit product', 'guard_name' =>  'web']);
        Permission::create(['name' => 'delete product', 'guard_name' =>  'web']);

        // ..
        Permission::create(['name' => 'manage content', 'guard_name' =>  'web']);
        Permission::create(['name' => 'create content', 'guard_name' =>  'web']);
        Permission::create(['name' => 'display content', 'guard_name' =>  'web']);
        Permission::create(['name' => 'edit content', 'guard_name' =>  'web']);
        Permission::create(['name' => 'delete content', 'guard_name' =>  'web']);

        Permission::create(['name' => 'manage new item', 'guard_name' =>  'web']);
        Permission::create(['name' => 'create newitem', 'guard_name' =>  'web']);
        Permission::create(['name' => 'display new item', 'guard_name' =>  'web']);
        Permission::create(['name' => 'edit new item', 'guard_name' =>  'web']);
        Permission::create(['name' => 'delete new item', 'guard_name' =>  'web']);

        Permission::create(['name' => 'manage image', 'guard_name' =>  'web']);
        Permission::create(['name' => 'create image', 'guard_name' =>  'web']);
        Permission::create(['name' => 'display image', 'guard_name' =>  'web']);
        Permission::create(['name' => 'edit image', 'guard_name' =>  'web']);
        Permission::create(['name' => 'delete image', 'guard_name' =>  'web']);
    }
}
