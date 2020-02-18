<?php

use Illuminate\Database\Seeder;
use App\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['name' => 'Vilnius'],
            ['name' => 'Kaunas'],
            ['name' => 'Klaipėda']
        ];

        City::insert($cities);
    }
}
