<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates master service types table and adds FK to builder_services
     */
    public function up(): void
    {
        // Step 1: Create master table first
        if (!Schema::hasTable('builder_service_types')) {
            Schema::create('builder_service_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('icon')->nullable()->comment('Font Awesome icon class, e.g. fa-hard-hat');
                $table->tinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
                $table->timestamps();
            });
        }

        // Step 2: Add FK to builder_services if not already exists
        if (!Schema::hasColumn('builder_services', 'service_type_id')) {
            Schema::table('builder_services', function (Blueprint $table) {
                $table->unsignedBigInteger('service_type_id')->nullable()->after('builder_id');
                $table->foreign('service_type_id')
                    ->references('id')
                    ->on('builder_service_types')
                    ->onDelete('cascade');
            });
        } else {
            // Column exists but may not have FK constraint — add it safely
            Schema::table('builder_services', function (Blueprint $table) {
                $table->unsignedBigInteger('service_type_id')->nullable()->change();
                try {
                    $table->foreign('service_type_id')
                        ->references('id')
                        ->on('builder_service_types')
                        ->onDelete('cascade');
                } catch (\Exception $e) {
                    // FK may already exist, ignore
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('builder_services', function (Blueprint $table) {
            $table->dropForeign(['service_type_id']);
            $table->dropColumn('service_type_id');
        });
        Schema::dropIfExists('builder_service_types');
    }
};
