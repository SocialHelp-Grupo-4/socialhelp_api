<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateLocationRequest;
use App\Http\Requests\Web\UpdateLocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{

    public function __construct(
        private LocationService $service
    ) {
    }


    public function index()
    {
        return Inertia::render(
            'location/Index',
            [
                'locations' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('location/Create');
    }

    public function store(CreateLocationRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('location.index')
            ->with('success', 'Comunidade criada com sucesso');
    }

    public function edit(Location $location)
    {
        return Inertia::render(
            'location/Edit',
            [
                'location' => $location,
            ]
        );
    }

     public function update(UpdateLocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(Location $location)
    {
        $this->service->remove($location);

        return redirect()->back()->with('success', 'Removido');
    }
}
