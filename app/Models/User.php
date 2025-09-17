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
        'password',
        'role',
        'pricing_level',
        'pf_level_id',
        'tf_level_id',
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

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function pricingLevel()
    {
        return $this->belongsTo(PricingLevel::class);
    }

    public function pfLevel()
    {
        return $this->belongsTo(PricingLevel::class, 'pf_level_id');
    }

    public function tfLevel()
    {
        return $this->belongsTo(PricingLevel::class, 'tf_level_id');
    }
}
