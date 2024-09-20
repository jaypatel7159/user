<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryStateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usa = Country::create(['name' => 'USA']);
        $india = Country::create(['name' => 'India']);
        
        $california = State::create(['name' => 'California', 'country_id' => $usa->id]);
        $texas = State::create(['name' => 'Texas', 'country_id' => $usa->id]);
        $gujarat = State::create(['name' => 'Gujarat', 'country_id' => $india->id]);
        
        City::create(['name' => 'Los Angeles', 'state_id' => $california->id]);
        City::create(['name' => 'San Francisco', 'state_id' => $california->id]);
        City::create(['name' => 'Dallas', 'state_id' => $texas->id]);
        City::create(['name' => 'Ahmedabad', 'state_id' => $gujarat->id]);
    }
}
