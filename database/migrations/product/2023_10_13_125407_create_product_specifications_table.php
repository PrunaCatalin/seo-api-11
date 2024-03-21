<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Tenants\App\Enums\EnumProductGenderType;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('product_brand')->onDelete('cascade');
            $table->integer('views')->default(0)->comment('Nr of views');
            $table->integer('warranty')->default(0)->comment('Warranty -> nr of months');
            $table->enum('gender', [
                EnumProductGenderType::FEMALE,
                EnumProductGenderType::MALE,
                EnumProductGenderType::UNISEX,
                EnumProductGenderType::CHILDREN
            ])->default(EnumProductGenderType::UNISEX)
                ->comment('Product gender : 1 - FEMALE, 2 - MALE, 3 - UNISEX, 4 - CHILDREN');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_specifications');
    }
};
