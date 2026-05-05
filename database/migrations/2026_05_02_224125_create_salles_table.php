<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                                              // ex: Salle A1
            $table->string('code')->unique();                                   // ex: A1
            $table->integer('capacite')->default(30);
            $table->enum('type', ['cours', 'td', 'tp', 'amphi'])->default('cours');
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};