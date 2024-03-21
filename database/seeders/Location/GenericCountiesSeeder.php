<?php

namespace Database\Seeders\Location;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Location\GenericCounty;

class GenericCountiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (($open = fopen(storage_path('app/resource/locations/generic_county.csv'), "r")) !== false) {
            fgetcsv($open);

            while (($data = fgetcsv($open)) !== false) {
                GenericCounty::insert([
                    'country_id' => $data[3],
                    'code' => $data[1],
                    'name' => $data[2],
                ]);
            }

            fclose($open);
        }
    }
}
