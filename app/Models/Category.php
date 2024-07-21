<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the services under this category.
     */
    public function services()
    {
        return $this->hasMany(LaboratoryService::class);
    }
}
