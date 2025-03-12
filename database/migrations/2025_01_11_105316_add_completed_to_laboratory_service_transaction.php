<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletedToLaboratoryServiceTransaction extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laboratory_service_transaction', function (Blueprint $table) {
            $table->boolean('completed')->default(false)->after('laboratory_service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laboratory_service_transaction', function (Blueprint $table) {
            $table->dropColumn('completed');
        });
    }
}
