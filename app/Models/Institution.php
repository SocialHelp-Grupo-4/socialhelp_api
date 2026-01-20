<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nif',
        'name',
        'email',
        'description',
        'status',
        'logo',
        'user_id',
        'institution_category_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\Enums\InstitutionStatus::class,
        ];
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'institution_addresses');
    }

    public function phoneNumbers()
    {
        return $this->hasMany(UserPhoneNumber::class);
    }

    public function category()
    {
        return $this->belongsTo(InstitutionCategory::class, 'institution_category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'institution_user')
            ->withPivot(['role', 'is_active'])
            ->withTimestamps();
    }

    public function invitations()
    {
        return $this->hasMany(InstitutionInvitation::class);
    }
}
