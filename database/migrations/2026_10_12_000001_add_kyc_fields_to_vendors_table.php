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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('gst_no', 50)->nullable()->after('phone_no');
            $table->string('pan_no', 20)->nullable()->after('gst_no');
            $table->string('proof_image')->nullable()->after('pan_no');
            $table->enum('kyc_status', ['Pending', 'Verified', 'Rejected'])->default('Verified')->after('proof_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['gst_no', 'pan_no', 'proof_image', 'kyc_status']);
        });
    }
};
