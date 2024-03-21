<?php

namespace Database\Seeders\App;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Modules\Tenants\App\Models\Company\AppConfig;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tenants = Tenant::all();
        $settings = [
            'company' => [
                'details' => [
                    'name' => 'SC Webdirect SRL',
                    'identifier_no' => 'RO27381152',
                    'identifier_no_commercial' => 'J15/451/2010',
                    'street' => 'Str Principala, nr 449, Ulmi, Dambovita',
                    'phone' => '0728 155 575',
                    'email' => 'contact@webdirect.ro',
                ]
            ],
            'google' => [
                'verificationUrl' => [
                    'url' => 'https://www.google.com/recaptcha/api/siteverify'
                ],
                'captcha' => [
                    'privateKey' => '6LfLScQUAAAAAHu0dB5GOnJ6prfb4MAU26V3rjHg',
                    'publicKey' => '6LfLScQUAAAAAKnanP7FHgKOuKqG0ijspjPaaX2f',
                ],
            ]
        ];
        foreach ($tenants as $tenant) {
            foreach ($settings as $configKey => $configValue) {
                foreach ($configValue as $configValueKey => $valueSettings) {
                    AppConfig::create([
                        'tenant_id' => $tenant->id,
                        'group_name' => $configKey,
                        'group_key' => $configValueKey,
                        'settings' => Crypt::encrypt(json_encode($valueSettings))
                    ]);
                }
            }
        }
    }
}
