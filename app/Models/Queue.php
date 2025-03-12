<?php
// app/Models/Queue.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'queuing_number',
        'status',
         'notes'


    ];
    protected $casts = [
        'status' => 'string',
    ];
   // Define the possible status values
   const STATUS_PENDING = 'pending';
   const STATUS_IN_PROGRESS = 'in_progress';
   const STATUS_DONE = 'done';
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
