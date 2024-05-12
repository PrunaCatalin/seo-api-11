<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->comment('FK -> customers');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('country_id')->comment('FK -> generic_countries');
            $table->foreign('country_id')->references('id')->on('generic_countries');
//            $table->unsignedBigInteger('city_id')->comment("FK -> generic_cities");
//            $table->foreign('city_id')->references('id')->on('generic_cities');
//
//            $table->unsignedBigInteger('county_id')->comment("FK -> generic_county");
//            $table->foreign('county_id')->references('id')->on('generic_county');

            $table->string('company_name')->comment('Company name');
            $table->integer('identifier')->comment('Only identifier of company');
            $table->string('swift')->comment('Company Bank swift');
            $table->string('bank_name')->comment('Company bank name');
            $table->string('iban_account')->comment('Company Bank Account');
            
            $table->string('company_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_companies');
    }
};
