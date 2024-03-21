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
        Schema::create('generic_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('county_id')->constrained("generic_county")->onDelete('cascade');
            $table->decimal('longitude', 18, 16);
            $table->decimal('latitude', 18, 16);
            $table->string('name', 64);
            $table->string('region', 64);
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
        Schema::dropIfExists('generic_cities');
    }
};
