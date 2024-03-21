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
//        Schema::create('customer_wishlist', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
//            $table->foreignId('product_id')->constrained()->onDelete('cascade');
//            $table->decimal('price');
//            $table->timestamps();
//            $table->softDeletes();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_wishlist');
    }
};
