<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * This method will define the structure of the 'order_products' table.
     * It includes references to 'orders' and 'products' tables to establish
     * a many-to-many relationship between orders and products. Additional
     * columns like 'quantity' and 'price' can store order-specific details
     * for each product.
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id()->comment('The primary key of the table.');
            $table->unsignedBigInteger('order_id')->comment('Foreign key linking to the orders table.');
            $table->unsignedBigInteger('product_id')->comment('Foreign key linking to the products table.');
            $table->integer('quantity')->comment('The quantity of the product in the order.');
            $table->decimal('price', 10, 2)->comment('The price of the product per unit.');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method will drop the 'order_products' table if it exists.
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
};
