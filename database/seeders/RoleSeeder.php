<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Super Admin
        $role = Role::create([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo(Permission::all());

        // Admin Simple
        // $role = Role::create([
        //     'name' => 'admin',
        //     'guard_name' => 'admin',
        // ]);
        // $role->givePermissionTo(Permission::all());
        // $role->revokePermissionTo('manage administrators');


        // content editor
        $role = Role::create([
            'name' => 'content-editor',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('manage content', 'create content', 'display content', 'edit content', 'create content');

        // // email editor
        // $role = Role::create([
        //     'name' => 'email-editor',
        //     'guard_name' =>  'web'
        // ]);
        // $role->givePermissionTo('manage email', 'create email', 'display email', 'edit email', 'create email');

        //   engineer


        $role = Role::create([
            'name' => 'product-editor',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('manage product', 'display product', 'edit product', 'create product', 'delete product');


        $role = Role::create([
            'name' => 'image-editor',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('manage image', 'display image', 'edit image', 'create image', 'delete image');



    }
}
