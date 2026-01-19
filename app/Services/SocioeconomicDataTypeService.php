<?php

namespace App\Services;

use App\Models\SocioeconomicDataType;

class SocioeconomicDataTypeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return SocioeconomicDataType::orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return SocioeconomicDataType::orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        return SocioeconomicDataType::create($data);
    }

    public function update(SocioeconomicDataType $socioeconomicDataType, array $data)
    {
        $socioeconomicDataType->update($data);
        return $socioeconomicDataType;
    }

    public function remove(SocioeconomicDataType $socioeconomicDataType)
    {
        $socioeconomicDataType->delete();
    }
}
