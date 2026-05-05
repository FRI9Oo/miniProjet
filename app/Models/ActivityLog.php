<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['action', 'description', 'emploi_id'];

    public function emploi()
    {
        return $this->belongsTo(EmploiDuTemps::class, 'emploi_id');
    }
}