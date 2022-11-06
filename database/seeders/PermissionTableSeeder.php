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
            'farm-create',
            'farm-edit',
            'farm-delete',
            'farm-list',
            'category-create',
            'category-edit',
            'category-delete',
            'category-list',
            'sub_category-create',
            'sub_category-edit',
            'sub_category-delete',
            'sub_category-list',
            'crop-create',
            'crop-edit',
            'crop-delete',
            'crop-list',
            'plot-create',
            'plot-edit',
            'plot-delete',
            'plot-list',
            'expense_category-create',
            'expense_category-edit',
            'expense_category-delete',
            'expense_category-list',
            'expense-create',
            'expense-edit',
            'expense-delete',
            'expense-list',
            'seller_product_category-create',
            'seller_product_category-edit',
            'seller_product_category-delete',
            'seller_product_category-list',
            'seller_product-create',
            'seller_product-edit',
            'seller_product-delete',
            'seller_product-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-list',



        ];

        foreach($permissions as $permission){
            Permission::create(['name'=>$permission]);
        }
    }
}
