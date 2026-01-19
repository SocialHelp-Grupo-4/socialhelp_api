<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateSocioeconomicDataTypeRequest;
use App\Http\Requests\Web\UpdateSocioeconomicDataTypeRequest;
use App\Models\SocioeconomicDataType;
use App\Services\SocioeconomicDataTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SocioeconomicDataTypeController extends Controller
{
    public function __construct(
        private SocioeconomicDataTypeService $service
    ) {
    }

    public function index()
    {
        return Inertia::render(
            'socioeconomic_data_type/Index',
            [
                'socioeconomicDataTypes' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('socioeconomic_data_type/Create');
    }

    public function store(CreateSocioeconomicDataTypeRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('socioeconomic_data_type.index')
            ->with('success', 'Tipo de dado socioeconômico criado com sucesso');
    }

    public function edit(SocioeconomicDataType $socioeconomicDataType)
    {
        return Inertia::render(
            'socioeconomic_data_type/Edit',
            [
                'socioeconomicDataType' => $socioeconomicDataType,
            ]
        );
    }

    public function update(UpdateSocioeconomicDataTypeRequest $request, SocioeconomicDataType $socioeconomicDataType)
    {
        $this->service->update($socioeconomicDataType, $request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(SocioeconomicDataType $socioeconomicDataType)
    {
        $this->service->remove($socioeconomicDataType);

        return redirect()->back()->with('success', 'Removido');
    }
}
