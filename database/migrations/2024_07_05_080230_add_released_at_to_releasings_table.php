<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleasedAtToReleasingsTable extends Migration
{
    public function up()
    {
        Schema::table('releasings', function (Blueprint $table) {
            $table->timestamp('released_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('releasings', function (Blueprint $table) {
            $table->dropColumn('released_at');
        });
    }
}
