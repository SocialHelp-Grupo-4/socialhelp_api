<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioeconomicData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'value',
        'socioeconomic_data_type_id',
    ];

    public function socioeconomicDataType()
    {
        return $this->belongsTo(SocioeconomicDataType::class);
    }
}
