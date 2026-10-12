<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_surveys', function (Blueprint $table) {
            $table->decimal('discount_amount', 10, 2)->default(0.00)->after('amount');
            $table->decimal('final_amount', 10, 2)->default(0.00)->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('customer_surveys', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'final_amount']);
        });
    }
};
