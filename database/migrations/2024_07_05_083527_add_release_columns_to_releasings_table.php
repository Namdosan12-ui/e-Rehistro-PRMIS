<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleaseColumnsToReleasingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('releasings', function (Blueprint $table) {
            $table->boolean('released_via_email')->default(false);
            $table->boolean('released_physical_copy')->default(false);
            $table->timestamp('released_at')->nullable();
            $table->string('releasing_status')->default('unreleased');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('releasings', function (Blueprint $table) {
            $table->dropColumn('released_via_email');
            $table->dropColumn('released_physical_copy');
            $table->dropColumn('released_at');
            $table->dropColumn('releasing_status');
        });
    }
}
