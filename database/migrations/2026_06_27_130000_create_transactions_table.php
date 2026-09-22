<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // No foreign key constraint
            $table->unsignedBigInteger('rel_id')->nullable();
            $table->enum('txn_for', ['survey', 'product', 'rental_product', 'course'])->nullable();
            $table->string('order_id')->unique()->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->enum('final_status', ['pending', 'success', 'failed'])->default('pending');
            $table->json('razorpay_payload')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
