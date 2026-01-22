<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InstitutionCategory;
use Illuminate\Http\Request;

class InstitutionCategoryController extends Controller
{
    public function index()
    {
        $categories = InstitutionCategory::all(['id', 'name']);
        return response()->json($categories);
    }
}
