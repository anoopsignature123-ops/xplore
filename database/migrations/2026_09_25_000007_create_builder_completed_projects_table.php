<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builder_completed_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('builder_id')->constrained('builders')->onDelete('cascade');
            $table->string('project_title');
            $table->string('location')->nullable();
            $table->string('area_details')->nullable(); // e.g. 4500 sqft luxury villa
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builder_completed_projects');
    }
};
