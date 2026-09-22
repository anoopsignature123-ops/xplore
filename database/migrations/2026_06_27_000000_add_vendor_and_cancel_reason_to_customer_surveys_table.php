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
        Schema::table('customer_surveys', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('customer_id');
            $table->text('reject_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_surveys', function (Blueprint $table) {
            $table->dropColumn(['vendor_id', 'reject_reason']);
        });
    }
};
