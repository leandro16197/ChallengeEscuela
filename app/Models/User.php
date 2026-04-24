<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password','role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role_relation()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role_relation && $this->role_relation->name === $roleName;
    }
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_user', 'user_id', 'curso_id')
                    ->withPivot('nota')
                    ->withTimestamps();
    }
    
}
