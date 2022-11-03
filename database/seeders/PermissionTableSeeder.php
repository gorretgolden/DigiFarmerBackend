<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permissions
        $permissions = [

            'role-create',
            'role-edit',
            'role-delete',
            'role-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'permission-list',
            'slider-create',
            'slider-edit',
            'slider-delete',
            'slider-list',
            'country-create',
            'country-edit',
            'country-delete',
            'country-list',
            'district-create',
            'district-edit',
            'district-delete',
            'district-list',
            'farm-create',
            'farm-edit',
            'farm-delete',
            'farm-list',
            'category-create',
            'category-edit',
            'category-delete',
            'category-list',
            'plot-create',
            'plot-edit',
            'plot-delete',
            'plot-list',
            'expense_category-create',
            'expense_category-edit',
            'expense_category-delete',
            'expense_category-list',
            'crop-create',
            'crop-edit',
            'crop-delete',
            'crop-list',
            'expense-create',
            'expense-edit',
            'expense-delete',
            'expense-list',
            'vendor-create',
            'vendor-edit',
            'vendor-delete',
            'vendor-list',



        ];

        foreach($permissions as $permission){
            Permission::create(['name'=>$permission]);
        }
    }
}
