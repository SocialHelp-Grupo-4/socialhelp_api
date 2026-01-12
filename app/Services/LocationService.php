<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return Location::orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return Location::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Location::create($data);
    }

    public function update(Location $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function remove(Location $category)
    {
        $category->delete();
    }
}
