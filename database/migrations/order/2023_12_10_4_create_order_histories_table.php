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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->uuid('internal_id');
            $table->string('status')->comment('The new status of the order.');
            $table->decimal('amount', 10, 2)->comment('Amount of the order.');
            $table->unsignedBigInteger('product_id')->default(0)->comment('Foreign key linking to the products table.');
            $table->unsignedBigInteger('subscription_id')->default(0)->comment(
                'Foreign key linking to the subscription_plan table.'
            );
            $table->unsignedBigInteger('customer_company_id')->default(0)->comment(
                'Optional foreign key linking to the customer_companies table.'
            );
            $table->string('external_id')->nullable()->comment('External id from payment method.');
            $table->text('comment')->nullable()->comment('Additional comments or details about the change.');
            $table->string('changed_by')->comment('The username of the user who made the change.');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_histories');
    }
};
