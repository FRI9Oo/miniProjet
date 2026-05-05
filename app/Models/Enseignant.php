<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'telephone',
        'specialite',
    ];

    // Full name accessor — use $enseignant->nom_complet anywhere
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // An enseignant has many emplois du temps
    public function emplois()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    // An enseignant has one user account
    public function user()
    {
        return $this->hasOne(User::class, 'enseignant_id');
    }
    protected static function booted(): void
    {
        static::deleting(function ($enseignant) {
            if ($enseignant->user) {
                $enseignant->user->delete();
            }
        });
    }
}