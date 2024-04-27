<?php

namespace Database\Seeders\Location;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Location\GenericCountry;

class GenericCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (($open = fopen(storage_path('app/resource/locations/generic_countries.csv'), 'r')) !== false) {
            fgetcsv($open);

            while (($data = fgetcsv($open)) !== false) {
                GenericCountry::insert([
                    'name' => $data[1],
                    'alpha_2' => $data[2],
                    'alpha_3' => $data[3],
                    'country_code' => $data[4],
                    'iso_3166_2' => $data[5],
                    'region' => $data[6],
                    'sub_region' => $data[7],
                    'intermediate_region' => $data[8],
                    'region_code' => $data[9],
                    'sub_region_code' => $data[10],
                    'intermediate_region_code' => $data[11],
                ]);
            }
            GenericCountry::insert([
                'name' => 'All',
                'alpha_2' => 'All',
                'alpha_3' => 'All',
                'country_code' => 'All',
                'iso_3166_2' => 'All',
                'region' => 'All',
                'sub_region' => 'All',
                'intermediate_region' => 'All',
                'region_code' => 'All',
                'sub_region_code' => 'All',
                'intermediate_region_code' => 'All',
            ]);
            fclose($open);
        }
    }
}
