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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique()->nullable();
            $table->enum('order_type', ['survey', 'product', 'rental_product', 'course']);
            $table->unsignedBigInteger('rel_id')->nullable()->comment('ID of the related record (survey, product, course, etc.)');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('address_type')->nullable();
            $table->text('address')->nullable();
            $table->string('city_name')->nullable();
            $table->string('state_name')->nullable();
            $table->string('pincode', 15)->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
};
