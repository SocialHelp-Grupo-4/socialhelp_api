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
            'address' => 'required|array',
            'address.country' => 'required',
            'address.province' => 'required',
            'address.municipality' => 'required',
            'address.morada' => 'required',
            'location_id' => 'required|exists:locations,id',
            // Add other validation rules as needed
        ]);

        $user = $request->user();

        // Transaction to ensure atomicity
        $family = \Illuminate\Support\Facades\DB::transaction(function () use ($request, $user) {
            // Create Address
            $address = \App\Models\Address::create($request->address);
            $user->addresses()->syncWithoutDetaching([$address->id]);

            // Create Family
            return $user->family()->create([
                'user_id' => $user->id,
                'location_id' => $request->location_id,
                'status' => \App\Enums\Enums\FamilyStatus::PENDING, // Default status
            ]);
        });

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
