<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('build_categories')->onDelete('set null');
            $table->string('name');
            $table->string('firm_name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('location')->nullable(); // e.g. Delhi, Lucknow
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->text('about')->nullable();
            $table->integer('experience_years')->default(0);
            $table->integer('projects_count')->default(0);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->boolean('is_verified')->default(true); // Blue badge
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builders');
    }
};
