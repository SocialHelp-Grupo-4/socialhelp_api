<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Administrador',
            'Gestor',
            'Técnico Social',
            'Analista',
            'Beneficiário',
        ];

        $guards = ['web', 'api'];

        foreach ($guards as $guard) {
            foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role, 'guard_name' => $guard]);
            }
        }
    }
}
