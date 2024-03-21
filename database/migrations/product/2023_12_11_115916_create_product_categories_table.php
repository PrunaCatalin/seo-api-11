<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations to create the product_categories table.
     * This table creates a many-to-many relationship between products and categories.
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id()->comment('Primary key of the table.');
            $table->unsignedBigInteger('product_id')->comment('Foreign key linking to the products table.');
            $table->unsignedBigInteger('category_id')->comment('Foreign key linking to the categories table.');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
