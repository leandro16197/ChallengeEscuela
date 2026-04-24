<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'name', 
        'teacher_id'
    ];

    public function profesor()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'curso_user', 'curso_id', 'user_id')
                    ->withPivot('nota')
                    ->withTimestamps();
    }
    
}
