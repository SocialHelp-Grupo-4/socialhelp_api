<?php

namespace App\Services;

use App\Models\Family;

class FamilyService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return Family::with(['location', 'user'])->orderBy('id')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return Family::orderBy('id')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Family::create($data);
    }

    public function update(Family $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function remove(Family $category)
    {
        $category->delete();
    }
}
