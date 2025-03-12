<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthday')->nullable(); // Adds the birthday column
            $table->string('profile_picture')->nullable(); // Adds the profile_picture column
            $table->string('license_no')->nullable(); // Adds the license_no column
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthday');
            $table->dropColumn('profile_picture');
            $table->dropColumn('license_no');
        });
    }
    
};
