<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        \App\Models\Role::create(['name' => 'admin', 'display_name' => 'Administrador']);
        \App\Models\Role::create(['name' => 'teacher', 'display_name' => 'Docente']);
        \App\Models\Role::create(['name' => 'student', 'display_name' => 'Estudiante']);
    }
}
