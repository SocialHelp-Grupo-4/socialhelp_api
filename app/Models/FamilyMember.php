<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'family_id',
        'name',
        'relationship',
        'age',
        'sex',
        'profession',
        'is_head',
        'has_income',
        'observation'
    ];

    protected $casts = [
        'is_head' => 'boolean',
        'has_income' => 'boolean',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
