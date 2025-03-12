<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'symptoms',
        'diagnoses',           // Added this
        'treatment_plan',
        'prescription',     // Added this
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
        'extremities',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'employment_history' => 'array',
        'ros' => 'array',
        'has_hpn' => 'boolean',
        'has_dm' => 'boolean',
        'has_ba' => 'boolean',
        'has_food_allergy' => 'boolean',
        'has_surgery' => 'boolean',
        'has_hospitalization' => 'boolean',
        'is_smoker' => 'boolean',
        'is_alcoholic' => 'boolean',
        'has_booster' => 'boolean',
        'weight' => 'float',
        'height' => 'float',
        'bmi' => 'float',
        'temp' => 'float'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
