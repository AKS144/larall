<?php

use Illuminate\Database\Seeder;

class ResturantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resturants')->insert([
            'name' => 'Number one pizza',
            'address' => 'Dream Valley',
            'city' => 'Vasco',
            'state' => 'Goa',
            'hours' => '9:00am-6:00pm',
            'latitude' => 28.452763,
            'longitute' => -81.412228,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('resturants')->insert([
            'name' => 'Number one pizza',
            'address' => 'Mangor',
            'city' => 'Vasco',
            'state' => 'Goa',
            'hours' => '10:00am-8:00pm',
            'latitude' => 28.473342,
            'longitute' => -81.491581,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('resturants')->insert([
            'name' => 'Number one pizza',
            'address' => 'Down mangor',
            'city' => 'Vasco',
            'state' => 'Goa',
            'hours' => '12:00pm-10:00pm',
            'latitude' => 28.526046,
            'longitute' => -81.396101,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
