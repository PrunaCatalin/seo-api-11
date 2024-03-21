<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * This method will define the structure of the 'order' table.
     * It includes references to 'customers', 'customer_companies', and 'order_shipments'
     * to track the order details along with the customer and shipping information.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment('The primary key of the table.');
            $table->unsignedBigInteger('customer_id')->comment('Foreign key linking to the customers table.');
            $table->unsignedBigInteger('customer_company_id')->nullable()->comment(
                'Optional foreign key linking to the customer_companies table.'
            );
            $table->unsignedBigInteger('shipment_id')->comment('Foreign key linking to the order_shipments table.');
            $table->string('status')->comment('The status of the order.');
            $table->decimal('total_price', 10, 2)->comment('The total price of the order.');
            $table->timestamps();
            $table->softDeletes()->comment(
                'Soft delete column to mark the record as deleted without actually removing it.'
            );

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('shipment_id')->references('id')->on('order_shipments');
            $table->foreign('customer_company_id')->references('id')->on('customer_companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method will drop the 'order' table if it exists.
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
