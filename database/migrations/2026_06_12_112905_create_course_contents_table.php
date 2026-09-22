<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('course_topics')->cascadeOnDelete();
            $table->enum('type', ['PDF', 'Video']);
            $table->string('name');
            $table->string('pdf')->nullable(); 
            $table->string('video_id')->nullable();
            $table->integer('priority')->default(0);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    } 

    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};