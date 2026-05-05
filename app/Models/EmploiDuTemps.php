<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'filiere_id',
        'enseignant_id',
        'salle_id',
        'matiere_id',
        'creneau_id',
        'notes',
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }

    // -------------------------------------------------------
    // CONFLICT DETECTION — call before saving
    // -------------------------------------------------------

    /**
     * Check if enseignant is already booked at this creneau.
     * Returns true if conflict exists.
     */
    public static function enseignantConflict(int $enseignantId, int $creneauId, ?int $excludeId = null): bool
    {
        return static::where('enseignant_id', $enseignantId)
            ->where('creneau_id', $creneauId)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }

    /**
     * Check if salle is already booked at this creneau.
     */
    public static function salleConflict(int $salleId, int $creneauId, ?int $excludeId = null): bool
    {
        return static::where('salle_id', $salleId)
            ->where('creneau_id', $creneauId)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }

    /**
     * Check if filiere already has a course at this creneau.
     */
    public static function filiereConflict(int $filiereId, int $creneauId, ?int $excludeId = null): bool
    {
        return static::where('filiere_id', $filiereId)
            ->where('creneau_id', $creneauId)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }
}