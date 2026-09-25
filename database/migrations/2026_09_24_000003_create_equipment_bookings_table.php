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
        Schema::create('equipment_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->integer('rental_duration_days')->default(1);
            $table->decimal('daily_rate', 10, 2)->default(0.00);
            $table->decimal('rental_cost', 10, 2)->default(0.00);
            $table->decimal('security_deposit', 10, 2)->default(0.00);
            $table->decimal('gst_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->enum('delivery_type', ['site_delivery', 'office_delivery', 'self_pickup'])->default('site_delivery');
            $table->foreignId('address_id')->nullable()->constrained('customer_addresses')->onDelete('set null');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('delivery_address')->nullable();
            $table->enum('booking_status', ['pending', 'confirmed', 'dispatched', 'delivered', 'returned', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_bookings');
    }
};
