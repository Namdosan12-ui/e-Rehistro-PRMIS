<?php
// app/Models/Releasing.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Releasing extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'released_at', 'result_file'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
