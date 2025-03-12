<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientType extends Model
{
    use HasFactory;

    // Adjust the $fillable property based on your actual table structure
    protected $fillable = ['type_name']; // Assuming 'type_name' is the column name in your database

    /**
     * Get the patients associated with this type.
     */
    public function patients()
    {
        return $this->hasMany(Patient::class, 'patient_type_id'); // Ensure 'patient_type_id' is the foreign key in your patients table
    }
}
