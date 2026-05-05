<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'volume_horaire',
        'type',
        'filiere_id',
    ];

    protected $casts = [
        'volume_horaire' => 'float',
    ];

    // A matiere belongs to a filiere
    public function filieres()
{
    return $this->belongsToMany(Filiere::class, 'filiere_matiere');
}

// Keep this for backward compatibility
public function filiere()
{
    return $this->belongsTo(Filiere::class);
}

    // A matiere has many emplois du temps
    public function emplois()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }
}