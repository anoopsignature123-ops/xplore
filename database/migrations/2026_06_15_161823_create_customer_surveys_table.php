<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');  
            $table->unsignedBigInteger('survey_id');  
            $table->string('survey_name')->nullable(); 
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->date('survey_date')->nullable(); 
            $table->time('survey_time')->nullable();
            $table->text('address')->nullable();  
            $table->enum('status', ['Pending', 'Ongoing', 'Completed', 'Rejected'])->default('Pending');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });   
    }
 
    public function down(): void
    {
        Schema::dropIfExists('customer_surveys');
    }
};