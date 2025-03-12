<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConsultationIdToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('consultation_id')->nullable()->after('id'); // Add the column

            $table->foreign('consultation_id')
                ->references('id')
                ->on('consultations')
                ->onDelete('set null') // Optional: Set to null if the consultation is deleted
                ->onUpdate('cascade'); // Optional: Cascade updates
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['consultation_id']);
            $table->dropColumn('consultation_id');
        });
    }
}
