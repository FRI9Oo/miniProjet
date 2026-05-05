<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filiere_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->unique(['filiere_id', 'matiere_id']);
        });

        // Migrate existing data from matieres.filiere_id to pivot table
        DB::statement('INSERT INTO filiere_matiere (filiere_id, matiere_id) SELECT filiere_id, id FROM matieres WHERE filiere_id IS NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('filiere_matiere');
    }
};