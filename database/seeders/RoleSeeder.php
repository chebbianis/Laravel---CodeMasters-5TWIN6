<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrateur avec accès complet à toutes les fonctionnalités',
                'permissions' => json_encode([
                    'users' => ['create', 'read', 'update', 'delete'],
                    'partners' => ['create', 'read', 'update', 'delete'],
                    'items' => ['create', 'read', 'update', 'delete'],
                    'events' => ['create', 'read', 'update', 'delete'],
                    'collection_points' => ['create', 'read', 'update', 'delete'],
                    'reports' => ['read'],
                    'settings' => ['update']
                ])
            ],
            [
                'name' => 'contributeur',
                'description' => 'Contributeur pouvant ajouter et modifier du contenu',
                'permissions' => json_encode([
                    'partners' => ['create', 'read', 'update'],
                    'items' => ['create', 'read', 'update'],
                    'events' => ['create', 'read', 'update'],
                    'collection_points' => ['read', 'update']
                ])
            ],
            [
                'name' => 'visiteur',
                'description' => 'Visiteur avec accès en lecture seule',
                'permissions' => json_encode([
                    'partners' => ['read'],
                    'items' => ['read'],
                    'events' => ['read'],
                    'collection_points' => ['read']
                ])
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
