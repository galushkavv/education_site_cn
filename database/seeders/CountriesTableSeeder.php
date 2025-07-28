<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create(['name' => 'China',   'locale' => 'zh']);
        Country::create(['name' => 'Russia',  'locale' => 'ru']);
        Country::create(['name' => 'Belarus', 'locale' => 'be']);
    }
}
