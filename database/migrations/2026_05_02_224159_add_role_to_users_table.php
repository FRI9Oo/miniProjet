<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add role + optional enseignant link to the users table created by Breeze.
     * Run AFTER the default Laravel users migration.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role: admin sees everything, enseignant sees own schedule, etudiant reads only
            $table->enum('role', ['admin', 'enseignant', 'etudiant'])
                  ->default('etudiant')
                  ->after('email');

            // Optional: link a user account to an enseignant profile
            $table->foreignId('enseignant_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('enseignants')
                  ->nullOnDelete();

            // Optional: link a student to their filiere for filtered timetable view
            $table->foreignId('filiere_id')
                  ->nullable()
                  ->after('enseignant_id')
                  ->constrained('filieres')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['enseignant_id']);
            $table->dropForeign(['filiere_id']);
            $table->dropColumn(['role', 'enseignant_id', 'filiere_id']);
        });
    }
};