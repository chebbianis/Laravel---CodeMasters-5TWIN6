<?php

namespace App\Exports;

use App\Models\Participation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Participation::with('event')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Événement',
            'Nom',
            'Email',
            'Statut',
            'Date d\'inscription',
            'Notes',
            'Créé le'
        ];
    }

    public function map($participation): array
    {
        $notes = json_decode($participation->notes, true);
        $feedback = $notes['feedback'] ?? ($notes['comment'] ?? 'Aucun');
        
        // Limiter manuellement le feedback
        if (strlen($feedback) > 50) {
            $feedback = substr($feedback, 0, 50) . '...';
        }
        
        return [
            $participation->id,
            $participation->event->title,
            $participation->participant_name,
            $participation->participant_email,
            $this->getStatusLabel($participation->status),
            $participation->registration_date->format('d/m/Y H:i'),
            $feedback,
            $participation->created_at->format('d/m/Y H:i'),
        ];
    }

    private function getStatusLabel($status)
    {
        $statuses = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmé',
            'cancelled' => 'Annulé'
        ];
        
        return $statuses[$status] ?? $status;
    }
}