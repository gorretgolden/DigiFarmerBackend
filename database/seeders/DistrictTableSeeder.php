<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts =[
            [
                'id'         => 1,
                'name'       => 'Kampala',
                'country_id'=> '225'

            ],
            [
                'id'         => 2,
                'name'       => 'Buikwe',
                'country_id'=> '225'

            ],
            [
                'id'         => 3,
                'name'       => 'Bukomansimbi',
                'country_id'=> '225'

            ],
            [
                'id'         => 4,
                'name'       => 'Butambala',
                'country_id'=> '225'

            ],
            [
                'id'         => 5,
                'name'       => 'Buvuma',
                'country_id'=> '225'

            ],
            [
                'id'         => 6,
                'name'       => 'Gomba',
                'country_id'=> '225'

            ],
            [
                'id'         => 7,
                'name'       => 'Gomba',
                'country_id'=> '225'

            ],
            ];

            District::insert($districts);
    }
}
