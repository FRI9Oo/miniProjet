<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                        // ex: Algorithmique
            $table->string('code')->unique();             // ex: ALG101
            $table->float('volume_horaire')->default(0); // total hours
            $table->enum('type', ['cours', 'td', 'tp'])->default('cours');
            $table->foreignId('filiere_id')
                  ->constrained('filieres')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};