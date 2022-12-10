<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_types =
        [

            [
                'id'         => 1,
                'name'       => 'admin'

            ],
            [
                'id'         => 2,
                'name'       => 'farmer'

            ],
            [
                'id'         => 3,
                'name'       => 'buyer'

            ],
            [
                'id'         => 4,
                'name'       => 'vendor'

            ],

        ];
        UserType::insert($user_types);
    }
}
