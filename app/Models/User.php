<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function profile_image_path()
    {
        if ($this->profile_img) {
            return asset('storage/employee/'. $this->profile_img);
        }
        return null;
    }

public function salaries()
{
    return $this->hasMany(Salary::class);
}
}
