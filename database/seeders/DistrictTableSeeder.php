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
                'name'       => 'Kalangala',
                'country_id'=> '225'

            ],
            [
                'id'         => 8,
                'name'       => 'Kampala',
                'country_id'=> '225'

            ],
            [
                'id'         => 9,
                'name'       => 'Kayunga',
                'country_id'=> '225'

            ],
            [
                'id'         => 10,
                'name'       => 'Kiboga',
                'country_id'=> '225'

            ],
            [
                'id'         => 11,
                'name'       => 'Kyankwanzi',
                'country_id'=> '225'

            ],
            [
                'id'         => 12,
                'name'       => 'Luwero',
                'country_id'=> '225'

            ],
            [
                'id'         => 13,
                'name'       => 'Lwengo',
                'country_id'=> '225'

            ],
            [
                'id'         => 14,
                'name'       => 'Lyantode',
                'country_id'=> '225'

            ],
            [
                'id'         => 15,
                'name'       => 'Masaka',
                'country_id'=> '225'

            ],
            [
                'id'         => 16,
                'name'       => 'Mityana',
                'country_id'=> '225'

            ],
            [
                'id'         => 17,
                'name'       => 'Mpigi',
                'country_id'=> '225'

            ],
            [
                'id'         => 18,
                'name'       => 'Mubende',
                'country_id'=> '225'

            ],
            [
                'id'         => 19,
                'name'       => 'Mukono',
                'country_id'=> '225'

            ],
            [
                'id'         => 20,
                'name'       => 'Nakaseke',
                'country_id'=> '225'

            ],
            [
                'id'         => 21,
                'name'       => 'Nakasongola',
                'country_id'=> '225'

            ],
            [
                'id'         => 22,
                'name'       => 'Rakai',
                'country_id'=> '225'

            ],
            [
                'id'         => 23,
                'name'       => 'Ssembabule',
                'country_id'=> '225'

            ],
            [
                'id'         => 24,
                'name'       => 'Wakiso',
                'country_id'=> '225'

            ],
            [
                'id'         => 25,
                'name'       => 'Jinja',
                'country_id'=> '225'

            ],
            ];

            District::insert($districts);
    }
}
