<?php

use App\Helpers\EnumHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Tenants\App\Enums\Order\OrderStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * This method will define the structure of the 'order' table.
     * It includes references to 'customers', 'customer_companies', and 'order_shipments'
     * to track the order details along with the customer and shipping information.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment('The primary key of the table.');
            $table->uuid('internal_id')->unique();
            $table->unsignedBigInteger('customer_id')->comment('Foreign key linking to the customers table.');
            $table->unsignedBigInteger('product_id')->default(0)->comment('Foreign key linking to the products table.');
            $table->unsignedBigInteger('subscription_id')->default(0)->comment(
                'Foreign key linking to the subscription_plan table.'
            );
            $table->unsignedBigInteger('payment_method_id')->comment(
                'Foreign key linking to the payment_method table.'
            );
            $table->unsignedBigInteger('customer_company_id')->default(0)->comment(
                'Optional foreign key linking to the customer_companies table.'
            );
            $table->enum('status', EnumHelper::getEnumValues(OrderStatus::class))->comment('The status of the order.');
            $table->decimal('amount', 10, 2)->comment('Amount of the order.');
            $table->string('external_id')->nullable()->comment('External id from payment method.');
            $table->timestamps();
            $table->softDeletes()->comment(
                'Soft delete column to mark the record as deleted without actually removing it.'
            );

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method will drop the 'order' table if it exists.
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
