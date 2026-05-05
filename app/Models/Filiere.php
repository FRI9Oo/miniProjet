<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'semestre',
        'description',
    ];

    // A filiere has many matieres
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'filiere_matiere');
    }

    // A filiere has many emplois du temps
    public function emplois()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    // A filiere has many users (students)
    public function etudiants()
    {
        return $this->hasMany(User::class, 'filiere_id');
    }
    
}