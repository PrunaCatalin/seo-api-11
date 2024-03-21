<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id')->comment("FK -> customers");
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('city_id')->comment("FK -> generic_cities");
            $table->foreign('city_id')->references('id')->on('generic_cities');

            $table->unsignedBigInteger('county_id')->comment("FK -> generic_county");
            $table->foreign('county_id')->references('id')->on('generic_county');
            $table->boolean('is_default')->default(false)->comment('Is Default address for customer');
            $table->string('person_name')
                ->comment("Person name for delivery");
            $table->string('person_lastname')
                ->comment("Person last name for delivery");
            $table->string('person_phone')
                ->comment("Person phone for delivery");
            $table->string('person_email')
                ->comment("Person email for delivery");
            $table->string('person_street_name')
                ->comment("Person street for delivery");
            $table->string('person_street_number')
                ->comment("Person street number for delivery")->nullable();
            $table->string('person_zip_code')
                ->comment("Person zip_code for delivery");
            $table->text('person_additional_info')
                ->comment("Person additional information delivery")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
};
