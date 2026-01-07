<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'criar projetos']);
        Permission::create(['name' => 'editar projetos']);
        Permission::create(['name' => 'avaliar famílias']);
        Permission::create(['name' => 'gerar relatórios']);
        Permission::create(['name' => 'publicar blog']);
    }
}
