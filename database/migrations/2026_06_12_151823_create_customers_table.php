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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone_no')->unique();
            $table->string('profile_image')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_sent_at')->nullable(); 
            $table->string('device_type')->nullable(); 
            $table->string('device_id')->nullable(); 
            $table->string('fcm_token')->nullable();
            $table->enum('status', ['Pending', 'Active', 'Inactive', 'Blocked'])->default('Pending');
            $table->timestamps();
            $table->softDeletes(); 
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
