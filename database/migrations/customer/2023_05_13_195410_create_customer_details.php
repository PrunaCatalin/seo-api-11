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
        Schema::create('customer_details', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->comment("Fk -> customers");
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('name')->comment("customer name");
            $table->string('lastname')->comment("customer lastname");
            $table->string('date_of_birth')->nullable()->comment("customer date of birth");
            $table->string('phone')->comment("customer phone");
            $table->boolean('gender')->default(false)->comment("Gender 0-> male, 1->female");
            // Add other fields as necessary
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
        Schema::dropIfExists('customer_details');
    }
};
