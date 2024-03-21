<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->default(0)->comment("Parent of link");
            $table->integer("position")->default(0)->comment("Order of element");
            $table->string('name')->comment('Menu label');
            $table->string('route')->comment('Route link based on name')->nullable();
            $table->string('icon')->comment('Menu Icon')->nullable();
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
        Schema::dropIfExists('admin_menu');
    }
};
