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

    protected $fillable = [
        'first_name', 'last_name', 'email', 'gender', 'hobbies', 'country', 'state', 'city', 'technologies', 'image'
    ];

    protected $casts = [
        'hobbies' => 'array',
        'technologies' => 'array'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }
}
