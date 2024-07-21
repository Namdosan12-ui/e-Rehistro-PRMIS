<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'descriptions',
        'fee',
        'category_id', // Ensure this matches the foreign key in your database schema
    ];

    /**
     * Get the category that owns the laboratory service.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'laboratory_service_transaction');
    }
    

}
