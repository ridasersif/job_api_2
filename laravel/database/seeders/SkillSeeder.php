<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        $skills = [
            ['name' => 'PHP', 'description' => 'Langage de programmation pour le côté serveur'],
            ['name' => 'JavaScript', 'description' => 'Langage de programmation pour les interfaces utilisateurs'],
            ['name' => 'HTML', 'description' => 'Langage de balisage pour créer des pages web'],
            ['name' => 'CSS', 'description' => 'Langage de style pour la mise en page des interfaces'],
            ['name' => 'React', 'description' => 'Bibliothèque JavaScript pour la création d\'interfaces utilisateurs'],
            ['name' => 'Laravel', 'description' => 'Framework PHP pour créer des applications web'],
            ['name' => 'Node.js', 'description' => 'Environnement d\'exécution JavaScript côté serveur'],
            ['name' => 'MySQL', 'description' => 'Système de gestion de base de données relationnelle'],
            ['name' => 'Git', 'description' => 'Système de contrôle de version'],
            ['name' => 'Docker', 'description' => 'Outil pour la gestion des conteneurs logiciels'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
