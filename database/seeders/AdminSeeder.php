<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = "#golden@";
        $admin = User::create([
            'first_name'=>'Farm',
            'last_name'=>'Digi',
            'username'=>'Digi Farm',
            'email'=>'admin@gmail.com',
            'phone'=>'0751547654',
            'password'=> Hash::make($password),
            'user_type'=>"admin",
            'country_id'=> 225,
            'isAdmin' => 1

        ]);


        $role = Role::create([
            'name'=>'admin'
        ]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole($role);

    }
}
