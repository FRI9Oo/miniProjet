<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'enseignant_id',
        'filiere_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // -------------------------------------------------------
    // ROLE HELPERS — use these in blade: auth()->user()->isAdmin()
    // -------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEnseignant(): bool
    {
        return $this->role === 'enseignant';
    }

    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    // Link to enseignant profile (if role = enseignant)
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    // Link to filiere (if role = etudiant)
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}