<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePatientTypesTable extends Migration
{
    public function up()
    {
        Schema::create('patient_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name')->unique(); // Changed column name to type_name
            $table->timestamps();
        });

        // Insert default types with specific IDs
        DB::table('patient_types')->insert([
            ['id' => 1, 'type_name' => 'HMO'],
            ['id' => 2, 'type_name' => 'Walk-in'],
            ['id' => 3, 'type_name' => 'APE'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('patient_types');
    }
}
