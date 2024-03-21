<?php

namespace Database\Seeders\Currency;

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Modules\Tenants\App\Models\Currency\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.exchangerate-api.com/v4/latest/EUR');
        $data = json_decode($response->getBody(), true);

        $currencies = [
            'EUR' => 'Euro',
            'RON' => 'Romanian Leu',
        ];

        foreach ($currencies as $code => $name) {
            Currency::updateOrCreate([
                'code' => $code,
                'name' => $name,
                'symbol' => $code,
                'rate' => $data['rates'][$code] ?? 0
            ]);
        }
    }
}
