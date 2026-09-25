<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builder_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('builder_id')->constrained('builders')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_image')->nullable();
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->text('review_text');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builder_reviews');
    }
};
