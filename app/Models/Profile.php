<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_number',
        'id_type',
        'doc_path',
        'first_name',
        'last_name',
        'sex',
        'about',
        'date_of_birth',
        'marital_status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'id_type' => \App\Enums\Enums\IDType::class,
            'marital_status' => \App\Enums\Enums\MaritalStatus::class,
            'sex' => \App\Enums\Sex::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
