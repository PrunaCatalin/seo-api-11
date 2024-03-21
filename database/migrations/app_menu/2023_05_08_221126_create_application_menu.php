<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Tenants\App\Enums\EnumMenuType;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_menu', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment('fk -> tenants.id');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->enum('menu_type', [
                EnumMenuType::PAGE,
                EnumMenuType::CATEGORY
            ])->default(EnumMenuType::PAGE)->comment('Type of menu');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('Parent of link');
            $table->integer('position')->default(0)->comment('Order of element');
            $table->string('name', 64)->comment('Name of link');
            $table->string('url_seo', 128)->comment('Url Seo');
            $table->string('icon', 128)->default('')->comment('Class icon');
            $table->tinyInteger('is_active')->default(0)->comment('Is Active : 0 -> No , 1 -> Yes');

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
        Schema::dropIfExists('frontend_application_links');
    }
};
