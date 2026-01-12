<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'status',
        'user_id',
        'location_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\Enums\FamilyStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function socioeconomicData()
    {
        return $this->hasMany(SocioeconomicFamilyData::class);
    }
}
