<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emplois_du_temps', function (Blueprint $table) {
            $table->id();

            // Core relationships
            $table->foreignId('filiere_id')
                  ->constrained('filieres')
                  ->onDelete('cascade');

            $table->foreignId('enseignant_id')
                  ->constrained('enseignants')
                  ->onDelete('cascade');

            $table->foreignId('salle_id')
                  ->constrained('salles')
                  ->onDelete('cascade');

            $table->foreignId('matiere_id')
                  ->constrained('matieres')
                  ->onDelete('cascade');

            $table->foreignId('creneau_id')
                  ->constrained('creneaux')
                  ->onDelete('cascade');

            $table->text('notes')->nullable();

            $table->timestamps();

            // -------------------------------------------------------
            // CONFLICT PREVENTION AT DATABASE LEVEL
            // -------------------------------------------------------

            // Rule 1: same enseignant cannot be in two places at same slot
            $table->unique(
                ['enseignant_id', 'creneau_id'],
                'unique_enseignant_creneau'
            );

            // Rule 2: same salle cannot host two groups at same slot
            $table->unique(
                ['salle_id', 'creneau_id'],
                'unique_salle_creneau'
            );

            // Rule 3: same filiere cannot have two courses at same slot
            $table->unique(
                ['filiere_id', 'creneau_id'],
                'unique_filiere_creneau'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emplois_du_temps');
    }
};