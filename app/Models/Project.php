<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'objectives',
        'start_date',
        'end_date',
        'status',
        'institution_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'status' => \App\Enums\Enums\ProjectStatus::class,
        ];
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function problemAreas()
    {
        return $this->belongsToMany(ProblemArea::class, 'project_problem_areas');
    }
}
