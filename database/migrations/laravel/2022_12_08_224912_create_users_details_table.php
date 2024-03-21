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
        Schema::create('users_details', function (Blueprint $table) {
            $table->unsignedBigInteger("user_id")->comment("fk -> users.id");
            $table->date("date_of_birth")->nullable()->comment("Date of Birthday");
            $table->tinyInteger("gender")->default(0)->comment("0 -> Male , 1 -> Female");
            $table->string("address")->nullable()->comment("Full Address");
            $table->string("phone")->nullable()->comment("Phone number");
            $table->string("avatar")->default("defaultAvatar.png")->comment("Avatar image");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_details');
    }
};
