<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return User::orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return User::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function remove(User $category)
    {
        $category->delete();
    }
}
