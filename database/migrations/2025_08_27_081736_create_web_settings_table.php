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
   Schema::create('web_settings', function (Blueprint $table) {
        $table->id();
        $table->string('company_name', 200)->nullable();
        $table->string('email_id', 200)->nullable();
        $table->string('phone_no', 10)->nullable();
        $table->string('whatsapp_no', 10)->nullable();
        $table->string('facebook_link')->nullable();
        $table->string('instagram_link')->nullable();
        $table->string('twitter_link')->nullable();
        $table->string('youtube_link')->nullable();
        $table->string('copyright')->nullable();
        $table->string('logo')->nullable();
        $table->string('favicon')->nullable();
        $table->text('address')->nullable();
      
        $table->timestamps();
    }); 



    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
