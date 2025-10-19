<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Utilisateurs - Waste To Product</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-back {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.3s;
            display: inline-block;
        }

        .btn-back:hover {
            transform: translateY(-2px);
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-card h3 {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            color: #666;
            font-size: 1rem;
        }

        .users-table-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow-x: auto;
        }

        .users-table-card h2 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }

        tbody tr {
            transition: background 0.3s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-admin {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .badge-user {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
        }

        .badge-active {
            background: #28a745;
            color: white;
        }

        .badge-inactive {
            background: #dc3545;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-role {
            background: #17a2b8;
            color: white;
        }

        .btn-toggle {
            background: #ffc107;
            color: #333;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 2rem;
            border-radius: 15px;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #667eea;
        }

        .modal-header h2 {
            color: #333;
            font-size: 1.5rem;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 600;
        }

        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn-cancel {
            padding: 0.8rem 1.5rem;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-confirm {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .current-user {
            color: #999;
            font-style: italic;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>👥</span>
                Gestion des Utilisateurs et Rôles
            </h1>
            <a href="{{ route('dashboard') }}" class="btn-back">← Retour au Dashboard</a>
        </div>

        <div id="alertContainer"></div>

        <!-- Statistiques -->
        <div class="stats-bar">
            <div class="stat-card">
                <div class="icon">👥</div>
                <h3>{{ $users->count() }}</h3>
                <p>Total Utilisateurs</p>
            </div>
            <div class="stat-card">
                <div class="icon">✅</div>
                <h3>{{ $users->where('is_active', true)->count() }}</h3>
                <p>Utilisateurs Actifs</p>
            </div>
            <div class="stat-card">
                <div class="icon">❌</div>
                <h3>{{ $users->where('is_active', false)->count() }}</h3>
                <p>Utilisateurs Inactifs</p>
            </div>
            <div class="stat-card">
                <div class="icon">👑</div>
                <h3>{{ $users->filter(fn($u) => $u->role->name === 'admin')->count() }}</h3>
                <p>Administrateurs</p>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="users-table-card">
            <h2>📋 Liste des Utilisateurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Dernière connexion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr data-user-id="{{ $user->id }}">
                        <td><strong>#{{ $user->id }}</strong></td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role->name === 'admin' ? 'badge-admin' : 'badge-user' }}" id="role-badge-{{ $user->id }}">
                                {{ $user->role->name === 'admin' ? '👑 Admin' : '👤 User' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}" id="status-badge-{{ $user->id }}">
                                {{ $user->is_active ? '✓ Actif' : '✗ Inactif' }}
                            </span>
                        </td>
                        <td>{{ $user->last_login ? $user->last_login->diffForHumans() : 'Jamais' }}</td>
                        <td>
                            @if($user->id !== auth()->id())
                                <div class="action-buttons">
                                    <button onclick="openRoleModal({{ $user->id }}, {{ $user->role_id }})" class="btn btn-role">
                                        🔄 Changer rôle
                                    </button>
                                    <button onclick="toggleStatus({{ $user->id }})" class="btn btn-toggle" id="toggle-btn-{{ $user->id }}">
                                        {{ $user->is_active ? '⏸️ Désactiver' : '▶️ Activer' }}
                                    </button>
                                    <button onclick="confirmDelete({{ $user->id }}, '{{ $user->username }}')" class="btn btn-delete">
                                        🗑️ Supprimer
                                    </button>
                                </div>
                            @else
                                <span class="current-user">🔒 Votre compte</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Changement de rôle -->
    <div id="roleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>🔄 Changer le Rôle</h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="newRole">Sélectionner un nouveau rôle :</label>
                    <select id="newRole">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name === 'admin' ? '👑 ' : '👤 ' }}{{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeRoleModal()" class="btn-cancel">Annuler</button>
                <button onclick="changeRole()" class="btn-confirm">Confirmer</button>
            </div>
        </div>
    </div>

    <script>
        let currentUserId = null;

        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alert.style.display = 'block';
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }

        function openRoleModal(userId, currentRoleId) {
            currentUserId = userId;
            document.getElementById('newRole').value = currentRoleId;
            document.getElementById('roleModal').style.display = 'block';
        }

        function closeRoleModal() {
            document.getElementById('roleModal').style.display = 'none';
            currentUserId = null;
        }

        async function changeRole() {
            const roleId = document.getElementById('newRole').value;

            try {
                const response = await fetch(`/admin/users/${currentUserId}/change-role`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ role_id: roleId })
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    closeRoleModal();
                    
                    // Mettre à jour le badge du rôle
                    const badge = document.getElementById(`role-badge-${currentUserId}`);
                    const isAdmin = data.new_role === 'admin';
                    badge.className = `badge ${isAdmin ? 'badge-admin' : 'badge-user'}`;
                    badge.textContent = isAdmin ? '👑 Admin' : '👤 User';
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erreur lors de la modification du rôle', 'error');
            }
        }

        async function toggleStatus(userId) {
            if (!confirm('Voulez-vous vraiment changer le statut de cet utilisateur ?')) {
                return;
            }

            try {
                const response = await fetch(`/admin/users/${userId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    
                    // Mettre à jour le badge de statut
                    const badge = document.getElementById(`status-badge-${userId}`);
                    badge.className = `badge ${data.is_active ? 'badge-active' : 'badge-inactive'}`;
                    badge.textContent = data.is_active ? '✓ Actif' : '✗ Inactif';
                    
                    // Mettre à jour le bouton
                    const btn = document.getElementById(`toggle-btn-${userId}`);
                    btn.textContent = data.is_active ? '⏸️ Désactiver' : '▶️ Activer';
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erreur lors de la modification du statut', 'error');
            }
        }

        async function confirmDelete(userId, username) {
            if (!confirm(`⚠️ ATTENTION ⚠️\n\nÊtes-vous vraiment sûr de vouloir supprimer l'utilisateur "${username}" ?\n\nCette action est IRRÉVERSIBLE !`)) {
                return;
            }

            try {
                const response = await fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Erreur lors de la suppression', 'error');
            }
        }

        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('roleModal');
            if (event.target === modal) {
                closeRoleModal();
            }
        }
    </script>
</body>
</html>
