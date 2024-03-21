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
        Schema::create( 'tenant_configuration', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedInteger('domain_id')->nullable(false)->comment("Fk -> domains.id");
            $table->text('endpoint')->nullable(false)->comment("This is used for client endpoint");
            $table->text('username')->nullable()->comment("Username for endpoint");
            $table->text('password')->nullable()->comment("Password for endpoint");
            $table->text('secret')->nullable()->comment("Secret key for endpoint");
            $table->text('tenant_type')->nullable()->comment("Type for tenant");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('domain_id')->references('id')->on('domains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_configuration');
    }
};
