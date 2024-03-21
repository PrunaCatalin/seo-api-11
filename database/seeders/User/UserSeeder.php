<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $primaryDomain = [
            Str::slug(env('APP_HOSTNAME'), ''),
        ];
        $domain = Str::slug(env('APP_HOSTNAME'), '');
        User::insert([
            'tenant_id' => $domain,
            'name' => 'Catalin Pruna new',
            'email' => $domain . '@yahoo.com',
            'password' => Hash::make('password')
        ]);
//        foreach($primaryDomain as $domain) {
//            if(!User::where("email" , $domain. "@yahoo.com")->first()){
//                User::create([
//                    "tenant_id" => $domain,
//                    "name" =>  "Catalin Pruna new",
//                    "email" => $domain. "@yahoo.com",
//                    "password" => Hash::make("password")
//                ]);
//           }
//        }

//        $user = User::find(1);
//        $user->assignRole('admin');
//        $role = Role::where('name', 'Administrator')->first();
//        $user->assignRole( 'Administrator', 'admin');
    }
}
