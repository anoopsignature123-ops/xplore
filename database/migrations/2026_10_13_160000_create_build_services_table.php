<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Main Build Services table (Admin-managed service packages)
        Schema::create('build_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('build_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('short_desc')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->enum('price_type', ['fixed', 'per_sqft', 'per_unit'])->default('fixed');
            $table->string('duration', 100)->nullable(); // "2-3 Days", "6-9 Months"
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->integer('total_reviews')->default(0);
            $table->json('tags')->nullable();              // ["Vastu Compliant","2 Revisions Included"]
            $table->longText('overview')->nullable();      // Long rich-text description
            $table->json('deliverables')->nullable();      // checkmark list items
            $table->json('what_you_get')->nullable();      // star bullet list items
            $table->json('execution_steps')->nullable();   // [{title, description}, ...]
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        // FAQs per service
        Schema::create('build_service_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('build_service_id')->constrained('build_services')->onDelete('cascade');
            $table->text('question');
            $table->text('answer');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Customer booking requests
        Schema::create('build_service_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('build_service_id')->constrained('build_services')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->text('site_location');
            $table->string('contact_mobile', 20);
            $table->string('target_timeline', 100)->nullable(); // "Within 15 Days"
            $table->string('budget_range', 100)->nullable();    // "₹50K - ₹2 Lakhs"
            $table->text('project_notes')->nullable();
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('build_service_bookings');
        Schema::dropIfExists('build_service_faqs');
        Schema::dropIfExists('build_services');
    }
};
