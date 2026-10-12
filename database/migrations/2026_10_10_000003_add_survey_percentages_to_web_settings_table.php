<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('web_settings', function (Blueprint $table) {
            $table->decimal('survey_booking_percentage', 5, 2)->default(40.00)->after('address');
            $table->decimal('survey_completion_percentage', 5, 2)->default(60.00)->after('survey_booking_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('web_settings', function (Blueprint $table) {
            $table->dropColumn(['survey_booking_percentage', 'survey_completion_percentage']);
        });
    }
};
