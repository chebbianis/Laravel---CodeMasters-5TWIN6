<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export des Participations</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .stats { margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Participations</h1>
        <p>Export généré le : {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="stats">
        <h3>Statistiques</h3>
        <p>Total: {{ $stats['total'] }} | Confirmés: {{ $stats['confirmed'] }} | En attente: {{ $stats['pending'] }} | Annulés: {{ $stats['cancelled'] }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Événement</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Date d'inscription</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participations as $participation)
            <tr>
                <td>{{ $participation->event->title }}</td>
                <td>{{ $participation->participant_name }}</td>
                <td>{{ $participation->participant_email }}</td>
                <td>
                    @if($participation->status == 'confirmed')
                        <span class="badge badge-success">Confirmé</span>
                    @elseif($participation->status == 'pending')
                        <span class="badge badge-warning">En attente</span>
                    @else
                        <span class="badge badge-danger">Annulé</span>
                    @endif
                </td>
                <td>{{ $participation->registration_date->format('d/m/Y H:i') }}</td>
                <td>
                    @php
                        $notes = json_decode($participation->notes, true);
                        $feedback = $notes['feedback'] ?? ($notes['comment'] ?? 'Aucun');
                        // Limiter manuellement sans utiliser Str::limit
                        if (strlen($feedback) > 50) {
                            $feedback = substr($feedback, 0, 50) . '...';
                        }
                    @endphp
                    {{ $feedback }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>