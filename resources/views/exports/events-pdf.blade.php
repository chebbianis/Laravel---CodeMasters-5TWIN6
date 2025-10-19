<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export des Événements</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Événements</h1>
        <p>Export généré le : {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Participants</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->type }}</td>
                <td>{{ $event->date->format('d/m/Y H:i') }}</td>
                <td>{{ $event->location }}</td>
                <td>{{ $event->participations_count }} / {{ $event->max_participants }}</td>
                <td>
                    @if($event->date > now())
                        <span class="badge badge-success">À venir</span>
                    @else
                        <span class="badge badge-secondary">Terminé</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center;">
        <p>Total : {{ $events->count() }} événement(s)</p>
    </div>
</body>
</html>