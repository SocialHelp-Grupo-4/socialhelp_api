<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioeconomicFamilyData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'family_id',
        'data_id',
        'description',
    ];

    public function socioeconomicData()
    {
        return $this->belongsTo(SocioeconomicData::class, 'data_id');
    }
}
