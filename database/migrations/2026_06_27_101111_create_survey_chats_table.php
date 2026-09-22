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
        Schema::create('survey_chats', function (Blueprint $table) {
            $table->id();
            // Store customer_survey_id without foreign key constraint
            $table->unsignedBigInteger('customer_survey_id');
            $table->enum('sender_type', ['vendor', 'customer']);
            $table->unsignedBigInteger('sender_id');
            $table->text('message')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('attachment_type')->nullable(); // 'image', 'pdf', etc.
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_chats');
    }
};
