<?php
// database/migrations/xxxx_xx_xx_create_discounts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('discount_type');
            $table->decimal('discount_amount', 5, 2);
            $table->timestamps();
        });

        // Seed initial discount types
        DB::table('discounts')->insert([
            ['discount_type' => 'Student', 'discount_amount' => 10.00],
            ['discount_type' => 'Senior Citizen', 'discount_amount' => 20.00],
            ['discount_type' => 'PWD', 'discount_amount' => 20.00],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
