<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaInstituicao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
    ];
}
