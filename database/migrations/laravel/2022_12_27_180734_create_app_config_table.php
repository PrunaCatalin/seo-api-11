<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_config', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment("fk -> tenants.id");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string('group_name')->comment("Group for keys");
            $table->string('group_key')->comment("Key for settings");
            $table->text('settings')->comment("Settings are encrypted by system");
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
        Schema::dropIfExists('app_config');
    }
};
