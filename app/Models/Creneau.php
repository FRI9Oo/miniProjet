<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    protected $table = 'creneaux';
    
    protected $fillable = [
        'jour',
        'heure_debut',
        'heure_fin',
        'libelle',
    ];

    // Order creneaux by day then time by default
    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function ($query) {
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            $query->orderByRaw('FIELD(jour, "' . implode('","', $jours) . '")')
                  ->orderBy('heure_debut');
        });
    }

    // A creneau has many emplois du temps
    public function emplois()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    // Label accessor — "Lundi 08:30 - 10:30"
    public function getLabelAttribute(): string
    {
        return $this->jour . ' ' . $this->heure_debut . ' - ' . $this->heure_fin;
    }
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}