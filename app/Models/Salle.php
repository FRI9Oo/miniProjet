<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'capacite',
        'type',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'capacite'   => 'integer',
    ];

    // A salle has many emplois du temps
    public function emplois()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    // Scope — only available rooms
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true);
    }
}