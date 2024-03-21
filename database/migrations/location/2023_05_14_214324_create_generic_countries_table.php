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
        Schema::create('generic_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->comment('Country Name');
            $table->string('alpha_2', 2)->comment('ISO-3166 Alpha-2 Country Code');
            $table->string('alpha_3', 3)->comment('ISO-3166 Alpha-3 Country Code');
            $table->string('country_code', 4)->comment('ISO-3166 Country Code');
            $table->string('iso_3166_2', 13)->comment('ISO-3166_2 Country Code');
            $table->string('region', 16)->comment('ISO-3166 Country Region');
            $table->string('sub_region', 64)->comment('ISO-3166 Country Sub-Region');
            $table->string('intermediate_region', 64)->comment('ISO-3166 Country Intermediate Region');
            $table->string('region_code', 3)->comment('ISO-3166 Country Region Code');
            $table->string('sub_region_code', 3)->comment('ISO-3166 Country Sub-Region Code');
            $table->string('intermediate_region_code', 3)->comment('ISO-3166 Intermediate Sub-Region Code');

            $table->index('alpha_2', 'countries_alpha_2_index');
            $table->index('alpha_3', 'countries_alpha_3_index');
            $table->index('country_code', 'countries_country_code_index');
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
        Schema::dropIfExists('generic_countries');
    }
};
