<?php

namespace Database\Seeders;

use App\Models\PartnerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnerTypes = [
            [
                'name' => 'ONG',
                'description' => 'Organisations non gouvernementales engagées dans l\'écologie et le développement durable'
            ],
            [
                'name' => 'Municipalité',
                'description' => 'Collectivités territoriales et services publics locaux'
            ],
            [
                'name' => 'Entreprise',
                'description' => 'Entreprises privées engagées dans la responsabilité sociale et environnementale'
            ],
            [
                'name' => 'Association',
                'description' => 'Associations locales et organisations à but non lucratif'
            ],
            [
                'name' => 'Établissement Public',
                'description' => 'Universités, écoles, hôpitaux et autres établissements publics'
            ]
        ];

        foreach ($partnerTypes as $type) {
            PartnerType::create($type);
        }
    }
}
