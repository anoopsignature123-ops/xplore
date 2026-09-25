<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builder_service_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('builder_id')->constrained('builders')->onDelete('cascade');
            $table->string('city_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builder_service_areas');
    }
};
