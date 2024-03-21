<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * This method will define the structure of the 'order_shipments' table.
     * It will store shipment details for each order, including the associated
     * carrier and customer address information.
     */
    public function up()
    {
        Schema::create('order_shipments', function (Blueprint $table) {
            $table->id()->comment('The primary key of the table.');
            $table->unsignedBigInteger('customer_address_id')
                ->comment('Foreign key linking to the customer_addresses table.');
            $table->unsignedBigInteger('carrier_id')
                ->comment('Foreign key linking to the carriers table.');
            $table->string('tracking_number')->nullable()
                ->comment('The tracking number for the shipment.');
            $table->dateTime('shipped_at')->nullable()
                ->comment('The date and time when the shipment was made.');
            $table->timestamps();
            $table->softDeletes()->comment(
                'Soft delete column to mark the record as deleted without actually removing it.'
            );
            $table->foreign('customer_address_id')->references('id')->on('customer_addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method will drop the 'order_shipments' table if it exists.
     */
    public function down()
    {
        Schema::dropIfExists('order_shipments');
    }
};
