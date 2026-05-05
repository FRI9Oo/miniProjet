<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // 1. FILIERES
        // -------------------------------------------------------
        DB::table('filieres')->insert([
            ['nom' => 'MGSI',         'code' => 'MGSI-S6', 'semestre' => 6, 'description' => 'Management et Génie des Systèmes Informatiques', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Informatique', 'code' => 'INFO-S6', 'semestre' => 6, 'description' => 'Génie Informatique',                              'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Mathématiques','code' => 'MATH-S6', 'semestre' => 6, 'description' => 'Mathématiques Appliquées',                        'created_at' => now(), 'updated_at' => now()],
        ]);

        // -------------------------------------------------------
        // 2. ENSEIGNANTS
        // -------------------------------------------------------
        DB::table('enseignants')->insert([
            ['nom' => 'Laassem',  'prenom' => 'Brahim',  'email' => 'b.laassem@ensiasd.ma',  'telephone' => '0612000001', 'specialite' => 'Développement Web',     'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Alaoui',   'prenom' => 'Fatima',  'email' => 'f.alaoui@ensiasd.ma',   'telephone' => '0612000002', 'specialite' => 'Base de Données',       'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Bennani',  'prenom' => 'Youssef', 'email' => 'y.bennani@ensiasd.ma',  'telephone' => '0612000003', 'specialite' => 'Algorithmique',         'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Chakir',   'prenom' => 'Sara',    'email' => 's.chakir@ensiasd.ma',   'telephone' => '0612000004', 'specialite' => 'Mathématiques',         'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'El Idrissi','prenom'=> 'Hamza',   'email' => 'h.elidrissi@ensiasd.ma','telephone' => '0612000005', 'specialite' => 'Réseaux & Systèmes',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // -------------------------------------------------------
        // 3. SALLES
        // -------------------------------------------------------
        DB::table('salles')->insert([
            ['nom' => 'Salle A1',   'code' => 'A1',    'capacite' => 35, 'type' => 'cours',  'disponible' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Salle A2',   'code' => 'A2',    'capacite' => 35, 'type' => 'cours',  'disponible' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Labo Info',  'code' => 'LAB1',  'capacite' => 25, 'type' => 'tp',     'disponible' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Amphithéâtre','code'=> 'AMPHI', 'capacite' => 120,'type' => 'amphi',  'disponible' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Salle TD1',  'code' => 'TD1',   'capacite' => 20, 'type' => 'td',     'disponible' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // -------------------------------------------------------
        // 4. MATIERES  (filiere_id: 1=MGSI, 2=INFO, 3=MATH)
        // -------------------------------------------------------
        DB::table('matieres')->insert([
            ['nom' => 'Développement Web',   'code' => 'DW101',  'volume_horaire' => 45, 'type' => 'cours', 'filiere_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Base de Données',     'code' => 'BD101',  'volume_horaire' => 40, 'type' => 'cours', 'filiere_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Algorithmique',       'code' => 'ALG101', 'volume_horaire' => 35, 'type' => 'cours', 'filiere_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Réseaux',             'code' => 'RES101', 'volume_horaire' => 30, 'type' => 'cours', 'filiere_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Analyse Mathématique','code' => 'ANA101', 'volume_horaire' => 50, 'type' => 'cours', 'filiere_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // -------------------------------------------------------
        // 5. CRENEAUX
        // -------------------------------------------------------
        $creneaux = [];
        $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi'];
        $slots = [
            ['08:30','10:30','Créneau 1 - Matin'],
            ['10:45','12:45','Créneau 2 - Matin'],
            ['14:00','16:00','Créneau 3 - Après-midi'],
            ['16:15','18:15','Créneau 4 - Après-midi'],
        ];
        foreach ($jours as $jour) {
            foreach ($slots as $slot) {
                $creneaux[] = [
                    'jour'        => $jour,
                    'heure_debut' => $slot[0],
                    'heure_fin'   => $slot[1],
                    'libelle'     => $slot[2],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }
        DB::table('creneaux')->insert($creneaux);

        // -------------------------------------------------------
        // 6. EMPLOIS DU TEMPS  (sample — no conflicts)
        //    creneau_id: Lundi slots = 1,2,3,4 | Mardi = 5,6,7,8 ...
        // -------------------------------------------------------
        DB::table('emplois_du_temps')->insert([
            // Lundi matin — MGSI: Dev Web, Salle A1, Laassem
            ['filiere_id'=>1,'enseignant_id'=>1,'salle_id'=>1,'matiere_id'=>1,'creneau_id'=>1,'notes'=>null,'created_at'=>now(),'updated_at'=>now()],
            // Lundi matin — INFO: Algo, Salle A2, Bennani
            ['filiere_id'=>2,'enseignant_id'=>3,'salle_id'=>2,'matiere_id'=>3,'creneau_id'=>1,'notes'=>null,'created_at'=>now(),'updated_at'=>now()],
            // Lundi créneau 2 — MGSI: BD, Salle A1, Alaoui
            ['filiere_id'=>1,'enseignant_id'=>2,'salle_id'=>1,'matiere_id'=>2,'creneau_id'=>2,'notes'=>null,'created_at'=>now(),'updated_at'=>now()],
            // Mardi créneau 1 — INFO: Réseaux, Labo, El Idrissi
            ['filiere_id'=>2,'enseignant_id'=>5,'salle_id'=>3,'matiere_id'=>4,'creneau_id'=>5,'notes'=>null,'created_at'=>now(),'updated_at'=>now()],
            // Mardi créneau 2 — MATH: Analyse, Amphi, Chakir
            ['filiere_id'=>3,'enseignant_id'=>4,'salle_id'=>4,'matiere_id'=>5,'creneau_id'=>6,'notes'=>null,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // -------------------------------------------------------
        // 7. USERS — default admin + one per role
        // -------------------------------------------------------
        DB::table('users')->insert([
            [
                // Required admin account — credentials must match exactly
                'name'          => 'Administrateur',
                'email'         => 'admin@ensiasd.ma',
                'password'      => Hash::make('ENSIASD2026'),
                'role'          => 'admin',
                'enseignant_id' => null,
                'filiere_id'    => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Laassem Brahim',
                'email'         => 'b.laassem@ensiasd.ma',
                'password'      => Hash::make('enseignant123'),
                'role'          => 'enseignant',
                'enseignant_id' => 1,
                'filiere_id'    => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Rokia Lemouda',
                'email'         => 'r.lemouda@ensiasd.ma',
                'password'      => Hash::make('etudiant123'),
                'role'          => 'etudiant',
                'enseignant_id' => null,
                'filiere_id'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}