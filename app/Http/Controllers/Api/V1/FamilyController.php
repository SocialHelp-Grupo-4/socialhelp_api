<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Enums\FamilyStatus;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::with(['user.profile', 'user.addresses', 'members', 'location'])->paginate(15);
        return response()->json($families);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'status' => ['required', 'string'],
            'address' => 'sometimes|array',
            'address.country' => 'required_with:address',
            'address.province' => 'required_with:address',
            'address.municipality' => 'required_with:address',
            'address.morada' => 'required_with:address',
            'members' => 'sometimes|array',
            'members.*.name' => 'required|string',
            'members.*.relationship' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $family = Family::create([
                'user_id' => $request->user_id,
                'location_id' => $request->location_id,
                'status' => $request->status,
            ]);

            // Handle Address
            if ($request->has('address')) {
                $address = Address::create($request->address);
                $user = User::find($request->user_id);
                $user->addresses()->syncWithoutDetaching([$address->id]);
            }

            // Handle Members
            if ($request->has('members')) {
                $family->members()->createMany($request->members);
            }

            DB::commit();

            return response()->json($family->load(['members', 'user.addresses']), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create family', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $family = Family::with(['user.profile', 'user.addresses', 'members', 'location', 'socioeconomicData'])->find($id);

        if (!$family) {
            return response()->json(['message' => 'Family not found'], 404);
        }

        return response()->json($family);
    }

    public function update(Request $request, $id)
    {
        $family = Family::find($id);

        if (!$family) {
            return response()->json(['message' => 'Family not found'], 404);
        }

        $family->update($request->only(['status', 'location_id']));

        return response()->json($family);
    }

    public function destroy($id)
    {
        $family = Family::find($id);

        if (!$family) {
            return response()->json(['message' => 'Family not found'], 404);
        }

        $family->delete();

        return response()->json(null, 204);
    }
}
