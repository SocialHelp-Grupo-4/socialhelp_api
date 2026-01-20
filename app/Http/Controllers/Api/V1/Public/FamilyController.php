<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $family = $user->family()->with('members')->first();

        if (!$family) {
            return response()->json(['message' => 'No family registered.'], 404);
        }

        return response()->json($family);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            // Add validation rules
        ]);

        $user = $request->user();

        $family = $user->family()->create([
            'user_id' => $user->id,
            'address' => $request->address,
            // ...
        ]);

        return response()->json($family, 201);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $family = $user->family;

        if (!$family) {
            return response()->json(['message' => 'Family not found.'], 404);
        }

        $family->update($request->all());

        return response()->json($family);
    }
}
