<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Queue;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'date', 'total_payments', 'last_meal',
        'physician', 'radiologic_technologist',
        'drug_test_purpose', 'other_purpose_specify', // Include other_purpose_specify for drug_test_purpose
        'medication_past_30_days', 'alcohol_past_24_hours',
        'sample_type', 'confirmatory_testing_agreement',
        'sample_acknowledgement',
    ];
    

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($transaction) {
            if ($transaction->isDirty('payment_status') && $transaction->payment_status == 'paid') {
                $today = now()->format('Y-m-d');
                $queueCountToday = Queue::whereDate('created_at', $today)->count();
                $queuingNumber = $queueCountToday + 1;

                Queue::create([
                    'transaction_id' => $transaction->id,
                    'queuing_number' => $queuingNumber,
                    'status' => 'pending',
                ]);
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function services()
    {
        return $this->belongsToMany(LaboratoryService::class, 'laboratory_service_transaction');
    }

    public function laboratory_services()
    {
        return $this->belongsToMany(LaboratoryService::class, 'laboratory_service_transaction', 'transaction_id', 'laboratory_service_id')
                    ->withPivot('fee'); // Assuming 'fee' is the additional pivot column you have
    }

    public function laboratoryServices()
    {
        return $this->belongsToMany(LaboratoryService::class, 'laboratory_service_transaction', 'transaction_id', 'laboratory_service_id');
    }

    public function queue()
    {
        return $this->hasOne(Queue::class);
    }
}
