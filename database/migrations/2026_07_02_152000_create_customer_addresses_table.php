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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->enum('address_type', ['home', 'office', 'other'])->default('home');
            $table->text('address');
            $table->string('pincode');
            $table->string('city_name');
            $table->string('state_name'); 
            $table->enum('set_as_default', ['yes', 'no'])->default('no');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void 
    {
        Schema::dropIfExists('customer_addresses');
    }
};
