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
        Schema::create('product_price_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id')->comment("Fk -> product_stocks");
            $table->unsignedBigInteger('product_id')->comment("Fk -> products");
            $table->foreign('stock_id')->references('id')->on('product_stocks');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('price', 8, 2);
            $table->date('date');
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
        Schema::dropIfExists('histories_price');
    }
};
