<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Basic Info
            $table->string('marital_status')->nullable();
            $table->text('history_of_present_illness')->nullable();

            // Past Medical History
            $table->boolean('has_hpn')->default(false);
            $table->boolean('has_dm')->default(false);
            $table->boolean('has_ba')->default(false);
            $table->string('other_medical_history')->nullable();
            $table->string('medications')->nullable();
            $table->boolean('has_food_allergy')->default(false);
            $table->string('food_drug_allergy')->nullable();
            $table->boolean('has_surgery')->default(false);
            $table->string('surgery_history')->nullable();
            $table->boolean('has_hospitalization')->default(false);

            // Employment History
            $table->json('employment_history')->nullable(); // Will store company, tenure, position, hazard exposure
            $table->string('work_related_injury')->nullable();

            // Personal & Social History
            $table->boolean('is_smoker')->default(false);
            $table->integer('cigarette_sticks_per_day')->nullable();
            $table->integer('cigarette_years')->nullable();
            $table->boolean('is_alcoholic')->default(false);
            $table->string('alcohol_history')->nullable();

            // Vaccination
            $table->string('vaccination_history')->nullable();
            $table->integer('covid_vaccine_doses')->nullable();
            $table->boolean('has_booster')->default(false);

            // Review of Systems (ROS)
            $table->json('ros')->nullable(); // Will store all ROS checkboxes

            // Physical Examination
            $table->text('physical_examination')->nullable(); // General Survey
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            $table->string('bp')->nullable();
            $table->integer('hr')->nullable();
            $table->decimal('temp', 4, 1)->nullable();

            // Physical Examination Findings
            $table->string('heent_status')->nullable();
            $table->string('heent')->nullable();
            $table->string('neck_status')->nullable();
            $table->string('neck')->nullable();
            $table->string('chest_and_lungs_status')->nullable();
            $table->string('chest_and_lungs')->nullable();
            $table->string('heart_status')->nullable();
            $table->string('heart')->nullable();
            $table->string('abdomen_status')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('extremities_status')->nullable();
            $table->string('extremities')->nullable();
        });
    }

    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'history_of_present_illness',
                'has_hpn',
                'has_dm',
                'has_ba',
                'other_medical_history',
                'medications',
                'has_food_allergy',
                'food_drug_allergy',
                'has_surgery',
                'surgery_history',
                'has_hospitalization',
                'employment_history',
                'work_related_injury',
                'is_smoker',
                'cigarette_sticks_per_day',
                'cigarette_years',
                'is_alcoholic',
                'alcohol_history',
                'vaccination_history',
                'covid_vaccine_doses',
                'has_booster',
                'ros',
                'physical_examination',
                'weight',
                'height',
                'bmi',
                'bp',
                'hr',
                'temp',
                'heent_status',
                'heent',
                'neck_status',
                'neck',
                'chest_and_lungs_status',
                'chest_and_lungs',
                'heart_status',
                'heart',
                'abdomen_status',
                'abdomen',
                'extremities_status',
                'extremities'
            ]);
        });
    }
};
