<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->enum('jour', [
                'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'
            ]);
            $table->time('heure_debut');                  // ex: 08:30
            $table->time('heure_fin');                    // ex: 10:30
            $table->string('libelle')->nullable();        // ex: "Créneau 1 - Matin"
            $table->timestamps();

            // Prevent duplicate time slots on same day
            $table->unique(['jour', 'heure_debut', 'heure_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};