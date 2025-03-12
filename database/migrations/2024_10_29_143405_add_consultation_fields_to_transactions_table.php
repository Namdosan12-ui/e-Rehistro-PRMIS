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
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'consultation_id')) {
                $table->unsignedBigInteger('consultation_id')->nullable();
                $table->foreign('consultation_id')
                    ->references('id')
                    ->on('consultations')
                    ->onDelete('set null');
            }

            if (!Schema::hasColumn('transactions', 'symptoms')) {
                $table->text('symptoms')->nullable();
            }

            if (!Schema::hasColumn('transactions', 'diagnoses')) {
                $table->text('diagnoses')->nullable();
            }

            if (!Schema::hasColumn('transactions', 'treatment_plan')) {
                $table->text('treatment_plan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['consultation_id']);

            // Then drop the columns
            $table->dropColumn([
                'consultation_id',
                'symptoms',
                'diagnoses',
                'treatment_plan'
            ]);
        });
    }
};
