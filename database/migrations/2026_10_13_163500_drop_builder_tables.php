<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop builder portal tables (no longer needed — services-only model)
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('builder_reviews');
        Schema::dropIfExists('builder_inquiries');
        Schema::dropIfExists('builder_portfolios');
        Schema::dropIfExists('builder_completed_projects');
        Schema::dropIfExists('builder_certifications');
        Schema::dropIfExists('builder_service_areas');
        Schema::dropIfExists('builder_services');
        Schema::dropIfExists('builders');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Intentionally left empty — one-way cleanup migration
    }
};
