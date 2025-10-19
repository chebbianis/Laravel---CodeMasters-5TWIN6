<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Dépôts - Waste To Product</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            overflow-y: auto;
        }

        .sidebar .logo {
            text-align: center;
            padding: 0 1rem;
            margin-bottom: 2rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 1rem 1.5rem;
            transition: all 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-menu .icon {
            margin-right: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 2.2rem;
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        /* Content */
        .content {
            padding: 2rem;
        }

        /* Stats Dashboard */
        .stats-dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .stat-card .number {
            font-size: 2.2rem;
            font-weight: bold;
            color: #FF9800;
            margin-bottom: 0.5rem;
        }

        .stat-card .label {
            color: #666;
            font-size: 1rem;
        }

        .stat-card .trend {
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .trend.up {
            color: #4CAF50;
        }

        .trend.down {
            color: #f44336;
        }

        /* Filters */
        .filters {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-weight: 500;
            color: #333;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }

        /* Deposits Table */
        .deposits-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .section-header {
            padding: 2rem;
            border-bottom: 2px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h2 {
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .deposits-table {
            width: 100%;
            border-collapse: collapse;
        }

        .deposits-table th,
        .deposits-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f8f9fa;
        }

        .deposits-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .deposits-table tr:hover {
            background: #f8f9fa;
        }

        /* Item badges */
        .item-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .item-electronics {
            background: #e3f2fd;
            color: #1976d2;
        }

        .item-furniture {
            background: #fff3e0;
            color: #f57c00;
        }

        .item-clothing {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .item-books {
            background: #e8f5e8;
            color: #388e3c;
        }

        /* Point badges */
        .point-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            background: #fff3cd;
            color: #856404;
        }

        /* Action buttons */
        .action-btn {
            padding: 0.4rem 0.8rem;
            margin: 0 0.2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-edit {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }

        /* Recent Deposits */
        .recent-deposits {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .recent-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            background: #f8f9fa;
            transition: all 0.3s;
        }

        .recent-item:hover {
            background: #e9ecef;
        }

        .recent-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }

        .recent-info {
            flex: 1;
        }

        .recent-title {
            font-weight: 600;
            color: #333;
        }

        .recent-details {
            color: #666;
            font-size: 0.9rem;
        }

        .recent-time {
            color: #999;
            font-size: 0.8rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 3rem;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal h2 {
            margin-bottom: 2rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn-cancel {
            background: #6c757d;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .filters {
                flex-direction: column;
            }

            .deposits-table {
                font-size: 0.8rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo">
        <h2>🔄 Waste To Product</h2>
        <p>Points de Collecte</p>
    </div>
    <ul class="nav-menu">
        <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
        <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue des Objets</a></li>
        <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
        <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
        <li><a href="{{ route('collection.points') }}"><span class="icon">🏢</span> Gestion des Points</a></li>
        <li><a href="{{ route('collection.deposits') }}" class="active"><span class="icon">📋</span> Gestion des Dépôts</a></li>
        <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
    </ul>
</aside>

<!-- Main Content -->
<main class="main-content">
    <header class="header">
        <div>
            <h1>Gestion des Dépôts</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> /
                <a href="{{ route('collection.index') }}">Points de Collecte</a> /
                Gestion des Dépôts
            </div>
        </div>
        <button class="btn btn-success" onclick="openAddModal()">+ Nouveau Dépôt</button>
    </header>

    <div class="content">
        <!-- Deposits Table -->
        <div class="deposits-section">
            <div class="section-header">
                <h2>📋 Liste des Dépôts</h2>
            </div>

            <table class="deposits-table">
                <thead>
                <tr>
                    <th>Date & Heure</th>
                    <th>Point de Collecte</th>
                    <th>Objet Déposé</th>
                    <th>Quantité</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deposits as $deposit)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($deposit->deposit_date)->format('d/m/Y') }}<br><small>{{ \Carbon\Carbon::parse($deposit->deposit_date)->format('H:i') }}</small></td>
                        <td><span class="point-badge">{{ $deposit->collectionPoint->name }}</span></td>
                        <td>
                            @php
                                $typeClass = match($deposit->item->type ?? '') {
                                    'electronics' => 'item-electronics',
                                    'furniture' => 'item-furniture',
                                    'clothing' => 'item-clothing',
                                    'books' => 'item-books',
                                    default => 'item-badge'
                                };
                            @endphp
                            <span class="item-badge {{ $typeClass }}">{{ $deposit->item->name }}</span>
                        </td>
                        <td>{{ $deposit->quantity }}</td>
                        <td>{{ $deposit->notes }}</td>
                        <td>
                            <form action="{{ route('deposits.destroy', $deposit->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete" title="Supprimer">🗑️</button>
                            </form>
                            <a href="{{ route('deposits.edit', $deposit->id) }}" class="action-btn btn-edit" title="Modifier">✏️</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Add Deposit Modal -->
<div id="addDepositModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" onclick="closeAddModal()">&times;</button>
        <h2>Enregistrer un Nouveau Dépôt</h2>

        <form action="{{ route('deposits.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Point de collecte</label>
                    <select name="point_id" required>
                        <option value="">Choisir un point</option>
                        @foreach($points as $point)
                            <option value="{{ $point->id }}">{{ $point->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Objet déposé</label>
                    <select name="item_id" required>
                        <option value="">Choisir un objet</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <input type="hidden" name="depositor_user_id" value="{{ auth()->user()->id }}">


            <div class="form-row">
                <div class="form-group">
                    <label>Date du dépôt</label>
                    <input type="date" name="deposit_date" required>
                </div>
                <div class="form-group">
                    <label>Quantité</label>
                    <input type="number" name="quantity" min="1" value="1" required>
                </div>
            </div>

            <div class="form-group">
                <label>Notes et observations</label>
                <textarea name="notes" placeholder="Détails sur l'état, défauts éventuels, instructions particulières..."></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="closeAddModal()">Annuler</button>
                <button type="submit" class="btn btn-success">Enregistrer le Dépôt</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addDepositModal').style.display = 'block';
    }

    function closeAddModal() {
        document.getElementById('addDepositModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('addDepositModal');
        if (event.target === modal) {
            closeAddModal();
        }
    }
</script>
</body>
</html>
