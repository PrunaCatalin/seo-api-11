<?php

namespace Database\Seeders\Location;

use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Location\GenericCity;

class GenericCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (($open = fopen(storage_path('app/resource/locations/generic_city.csv'), "r")) !== false) {
            // Sărim peste prima linie dacă CSV-ul tău are un header
            fgetcsv($open);

            while (($data = fgetcsv($open)) !== false) {
                GenericCity::insert([
                    'county_id' => $data[1], // Presupunând că primul câmp este county_id
                    'name' => $data[4], // Presupunând că al doilea câmp este name
                    'longitude' => $data[2], // Presupunând că al treilea câmp este longitude
                    'latitude' => $data[3], // Presupunând că al patrulea câmp este latitude
                    'region' => $data[5], // Presupunând că al patrulea câmp este latitude
                    // Ajustează indicii conform structurii fișierului tău CSV
                ]);
            }

            fclose($open);
        }
    }
}
