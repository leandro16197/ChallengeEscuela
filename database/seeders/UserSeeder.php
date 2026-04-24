<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [];
        $profesores = [];
        $alumnos = [];


        for ($i = 1; $i <= 2; $i++) {
            $admins[] = User::create([
                'name' => "Admin $i",
                'email' => "admin$i@school.com",
                'password' => Hash::make('admin'),
                'role' => 1,
            ]);
        }


        for ($i = 1; $i <= 4; $i++) {
            $profesores[] = User::create([
                'name' => "Profesor $i",
                'email' => "profesor$i@school.com",
                'password' => Hash::make('profesor'),
                'role' => 2,
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            $alumnos[] = User::create([
                'name' => "Estudiante $i",
                'email' => "estudiante$i@school.com",
                'password' => Hash::make('estudiante'),
                'role' => 3,
            ]);
        }


        $cursos = [];

        foreach ($profesores as $index => $profesor) {
            $cursos[] = Curso::create([
                'name' => "Curso " . ($index + 1),
                'teacher_id' => $profesor->id,
            ]);
        }

        foreach ($alumnos as $alumno) {
            foreach ($cursos as $curso) {

                $alumno->cursos()->attach($curso->id, [
                    'nota' => rand(1, 10)
                ]);
            }
        }
    }
}
