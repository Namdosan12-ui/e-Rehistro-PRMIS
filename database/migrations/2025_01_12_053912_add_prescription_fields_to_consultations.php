<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Add prescription field
            $table->text('prescription')->nullable()->after('treatment_plan');

            // Add physician information
            $table->string('physician_name')->nullable()->after('prescription');
            $table->string('license_no')->nullable()->after('physician_name');

            // Make diagnoses and treatment_plan nullable since they were required before
            $table->string('diagnoses')->nullable()->change();
            $table->string('treatment_plan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Remove the new columns
            $table->dropColumn([
                'prescription',
                'physician_name',
                'license_no'
            ]);

            // Revert diagnoses and treatment_plan to be required
            $table->string('diagnoses')->nullable(false)->change();
            $table->string('treatment_plan')->nullable(false)->change();
        });
    }
};
