<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'gender', 'contact_information', 'email_address', 'address',
        'civil_status', 'philhealth_number', 'pwd_id_number', 'occupation', 'senior_citizen_card_number',
        'emergency_contact_name', 'emergency_contact_mobile', 'emergency_contact_relation', 'vaccine_type',
        'first_dose_date', 'second_dose_date', 'booster_type', 'first_booster_date', 'second_booster_date',
        'patient_type_id',  'profile_picture',    'prescription',
        'physician_name','license_no',  'privacy_consent',
    'consent_date',
          // New vital signs fields
          'patient_weight',
          'patient_height',
          'patient_bmi',
          'patient_bp',
          'patient_heart_rate',
          'patient_temperature'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function patientType()
    {
        return $this->belongsTo(PatientType::class); // Add this relationship
    }
}
