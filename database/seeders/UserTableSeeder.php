<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ru_RU');
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // $all_roles_in_database = Role::all()->pluck('name');

        $user = User::create([
            'name' =>   'Иван',

            'last_name' =>   'Иванов',
            'patronymic' =>   'Иванович',
            'email' => 'admin@admin.com',
            'password' =>  '$2y$10$GuaoFnDw17nZcbNNDq6aO.1wZHpLr3hGyADjN14J0kj1yjrPxdHJm',                // 'password'
            'phone_number' =>    '790231323123',
            'is_admin' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        User::find(1)->assignRole('super-admin');

       app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // $all_roles_in_database = Role::all()->pluck('name');

        $user = User::create([
            'name' =>   'gordi2001@mail.ru',

            'last_name' =>   'gordi2001@mail.ru',
            'patronymic' =>   'gordi2001@mail.ru',
            'email' => 'gordi2001@mail.ru',
            'password' =>   Hash::make('gordi2001@mail.ru'),
            'phone_number' =>    '790231323123',
            'is_admin' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        User::find(2)->assignRole('super-admin');

        for ($i = 1; $i < 6; $i++) {

            $user = User::create([
                'name' =>  $faker->firstName,

                'last_name' => $faker->lastName,
                'patronymic' => $faker->middleName,
                'email' => 'user' . $i . '@admin.com',
                'password' =>  '$2y$10$GuaoFnDw17nZcbNNDq6aO.1wZHpLr3hGyADjN14J0kj1yjrPxdHJm',                // 'password'
                'phone_number' =>   $faker->numerify('+79#########'),
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->assignRole('content-editor');

        }


        for ($i = 7; $i < 10; $i++) {

            $user = User::create([
                'name' =>  $faker->firstName,
                'last_name' => $faker->lastName,
                'patronymic' => $faker->middleName,
                'email' => 'user' . $i . '@admin.com',
                'password' =>  '$2y$10$GuaoFnDw17nZcbNNDq6aO.1wZHpLr3hGyADjN14J0kj1yjrPxdHJm',                // 'password'
                'phone_number' =>   $faker->numerify('+79#########'),
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->assignRole('product-editor');

        }
                for ($i = 11; $i < 13; $i++) {

            $user = User::create([
                'name' =>  $faker->firstName,
                'last_name' => $faker->lastName,
                'patronymic' => $faker->middleName,
                'email' => 'user' . $i . '@admin.com',
                'password' =>  '$2y$10$GuaoFnDw17nZcbNNDq6aO.1wZHpLr3hGyADjN14J0kj1yjrPxdHJm',                // 'password'
                'phone_number' =>   $faker->numerify('+79#########'),
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->assignRole('image-editor');

        }
    }
}
