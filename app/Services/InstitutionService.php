<?php

namespace App\Services;

use App\Models\Institution;

class InstitutionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return Institution::orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return Institution::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Institution::create($data);
    }

    public function update(Institution $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function remove(Institution $category)
    {
        $category->delete();
    }
}
