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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment("Fk -> tenant (tenant relation)");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string('name')->unique()->comment("Product name");
            $table->string('seo_url')->unique()->comment("Product Seo Url");
            $table->string('sku')->unique()->comment("Product barcode unique IAN CODE");
            $table->string('unit_measure')->default("buc")->comment("Product Unit Measure");
            $table->longText('description')->charset('utf8mb4')->comment("Product Description");
            $table->text('short_description')->comment("Product short description");
            $table->tinyInteger('is_active')->default(1)
                ->comment("0 -> inactive , 1 -> active");
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
        Schema::dropIfExists('products');
    }
};
