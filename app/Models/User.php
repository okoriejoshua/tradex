<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'type',
        'role',
        'status',
        'password',
        'referralcode',
        'photo',
        'kyc_level',
        'username',
        'phone',
        'stage',
        'country',
        'gender',
        'dob',
        'address',
        'occupation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function referredBy()
    {
        return $this->hasOne(Referral::class, 'referred_user_id');
    }


    public function kycData()
    {
        return $this->hasOne(KycData::class);
    }

    public function verifycode()
    {
        return $this->hasOne(Verifycode::class);
    }
}
