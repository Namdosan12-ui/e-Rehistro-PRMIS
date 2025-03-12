<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'birthday',
        'profile_picture',
        'license_no',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'datetime',
    ];

    // Define the relationship with the Role model
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {

        return $this->role->role_name === 'Admin';
    }

    /**
     * Check if the user is a reception user.
     *
     * @return bool
     */
    public function isReception()
    {

        return $this->role->role_name === 'Reception';
    }

    /**
     * Check if the user is a medical technologist.
     *
     * @return bool
     */
    public function isMedicalTechnologist()
    {
        return $this->role->role_name === 'Medical Technologist';
    }


    /**
     * Check if the user is a medical technologist.
     *
     * @return bool
     */
    public function isRadilogicTechnologist()
    {
        return $this->role->role_name === 'Radiologic Technologist';
    }

      /**
     * Check if the user is a medical technologist.
     *
     * @return bool
     */
    public function isPhysician()
    {
        return $this->role->role_name === 'Physician';
    }
}
