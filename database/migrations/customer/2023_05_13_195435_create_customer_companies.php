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
            $table->unsignedBigInteger('customer_id')->comment("FK -> customers");
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('city_id')->comment("FK -> generic_cities");
            $table->foreign('city_id')->references('id')->on('generic_cities');

            $table->unsignedBigInteger('county_id')->comment("FK -> generic_county");
            $table->foreign('county_id')->references('id')->on('generic_county');

            $table->string('company_name')->comment("Company name");
            $table->string('prefix_code')->default("RO")->comment("It's refer to prefix of CUI");
            $table->integer('cui_code')->comment("Only number of cui");
            $table->string('commerce_reg_letter')->comment("Can be J / F / C or nothing");
            $table->string('county_code')->comment("Can start from 1 to 44 , or 50  to 52");
            $table->string('company_year')->comment("Company year");
            $table->string('bank_name')->comment("Company bank name");
            $table->string('iban_account')->comment("Company Bank Account");

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
