<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'profiles';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'profile_picture',
        'name',
        'email',
        'role_id',
        'birthday',
        'license_no',
    ];

    // Define the relationship between Profile and User
    public function user()
    {
        return $this->belongsTo(User::class); // Each profile belongs to a single user
    }

    // Define the relationship between Profile and Role (if applicable)
    public function role()
    {
        return $this->belongsTo(Role::class); // Each profile is associated with a single role
    }
}
