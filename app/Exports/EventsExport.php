<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Event::withCount(['participations' => function($query) {
            $query->where('status', 'confirmed');
        }])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Titre',
            'Type',
            'Date',
            'Lieu',
            'Participants Max',
            'Participants Confirmés',
            'Statut',
            'Créé le'
        ];
    }

    public function map($event): array
    {
        return [
            $event->id,
            $event->title,
            $event->type,
            $event->date->format('d/m/Y H:i'),
            $event->location,
            $event->max_participants,
            $event->participations_count,
            $event->date > now() ? 'À venir' : 'Terminé',
            $event->created_at->format('d/m/Y H:i'),
        ];
    }
}