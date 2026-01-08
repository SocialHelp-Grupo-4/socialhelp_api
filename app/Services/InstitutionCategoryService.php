<?php

namespace App\Services;

use App\Models\InstitutionCategory;

class InstitutionCategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return InstitutionCategory::orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return InstitutionCategory::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return InstitutionCategory::create($data);
    }

    public function update(InstitutionCategory $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function remove(InstitutionCategory $category)
    {
        $category->delete();
    }
}
