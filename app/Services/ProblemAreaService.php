<?php

namespace App\Services;

use App\Models\ProblemArea;

class ProblemAreaService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return ProblemArea::orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return ProblemArea::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return ProblemArea::create($data);
    }

    public function update(ProblemArea $problemArea, array $data)
    {
        $problemArea->update($data);
        return $problemArea;
    }

    public function remove(ProblemArea $problemArea)
    {
        $problemArea->delete();
    }
}
