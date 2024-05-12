<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Tenants\App\Enums\EnumTermsType;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->enum(
                'type',
                [
                    EnumTermsType::SMS->value,
                    EnumTermsType::EMAIL->value,
                    EnumTermsType::TERMS_AND_CONDITIONS->value,
                ]
            )->comment('Type of terms');
            $table->boolean('checked')->default(false)->comment('0 -> unchecked , 1 -> checked');
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
        Schema::dropIfExists('customer_terms');
    }
};
