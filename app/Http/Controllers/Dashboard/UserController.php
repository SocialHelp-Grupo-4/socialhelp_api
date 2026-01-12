<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateUserRequest;
use App\Http\Requests\Web\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    public function __construct(
        private UserService $service
    ) {
    }


    public function index()
    {
        return Inertia::render(
            'user/Index',
            [
                'users' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('user/Create');
    }

    public function store(CreateUserRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilizador criado com sucesso');
    }

    public function edit(User $user)
    {
        return Inertia::render(
            'user/Edit',
            [
                'user' => $user,
            ]
        );
    }

     public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(User $user)
    {
        $this->service->remove($user);

        return redirect()->back()->with('success', 'Removido');
    }
}
