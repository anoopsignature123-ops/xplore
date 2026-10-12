<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_surveys', function (Blueprint $table) {
            $table->decimal('booking_percentage', 5, 2)->default(40.00)->after('final_amount');
            $table->decimal('advance_amount', 10, 2)->default(0.00)->after('booking_percentage');
            $table->decimal('remaining_amount', 10, 2)->default(0.00)->after('advance_amount');
            $table->decimal('paid_amount', 10, 2)->default(0.00)->after('remaining_amount');
        });
    }

    public function down(): void
    {
        Schema::table('customer_surveys', function (Blueprint $table) {
            $table->dropColumn(['booking_percentage', 'advance_amount', 'remaining_amount', 'paid_amount']);
        });
    }
};
