<?php
// database/migrations/xxxx_xx_xx_create_releasings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasingsTable extends Migration
{
    public function up()
    {
        Schema::create('releasings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('result_file')->nullable(); // File path for uploaded PDF results
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('releasings');
    }
}
