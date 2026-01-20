<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'email',
        'role',
        'token',
        'status',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
