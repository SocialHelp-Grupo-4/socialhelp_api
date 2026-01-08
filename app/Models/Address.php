<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'province',
        'municipality',
        'morada',
        'geolocation',
    ];


    public function user()
    {
        return $this->belongsToMany(User::class, 'user_addresses');
    }
}
