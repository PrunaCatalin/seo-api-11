<?php
/*
 * ${PROJECT_NAME} | 2024_04_28_141701_create_orders_problems.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 28.04.2024 14:17
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations to create the orders_problems table.
     *
     * This table stores various problems associated with orders such as payment disputes,
     * declined transactions, or other payment-related issues.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_problems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('type')->comment('Type of the problem (e.g., dispute, declined).');
            $table->text('description')->nullable()->comment('Detailed description of the problem.');
            $table->enum('status', ['pending', 'resolved', 'unresolved'])
                ->default('pending')
                ->comment('Current status of the problem.');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This function will drop the orders_problems table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_problems');
    }
};
