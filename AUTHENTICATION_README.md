# Système d'Authentification - Waste To Product

## ✅ Fonctionnalités Implémentées

### 1. **Système de Rôles**
- **Rôle Admin** : Accès complet à toutes les fonctionnalités
- **Rôle User** : Accès limité aux fonctionnalités de base
- Création automatique des rôles lors de la première inscription

### 2. **Authentification**
- ✅ Inscription avec validation complète
- ✅ Connexion avec email et mot de passe
- ✅ Déconnexion sécurisée
- ✅ Option "Se souvenir de moi"
- ✅ Protection CSRF
- ✅ Gestion des erreurs de validation

### 3. **Sécurité**
- ✅ Hashage des mots de passe avec bcrypt
- ✅ Middleware d'authentification
- ✅ Middleware de vérification du rôle admin
- ✅ Protection des routes sensibles
- ✅ Validation des données côté serveur

### 4. **Interface Utilisateur**
- ✅ Page d'accueil avec formulaires login/register
- ✅ Page de connexion dédiée
- ✅ Page d'inscription dédiée
- ✅ Dashboard personnalisé selon le rôle
- ✅ Affichage des erreurs de validation
- ✅ Messages de succès/erreur

---

## 🔐 Comptes de Test

### Administrateur
```
Email: admin@waste.com
Mot de passe: admin123
Rôle: admin
```

### Utilisateur Standard
```
Email: user@waste.com
Mot de passe: user123
Rôle: user
```

---

## 📋 Routes Configurées

### Routes Publiques
- `GET /` - Page d'accueil
- `GET /login` - Page de connexion
- `POST /login` - Traitement de la connexion
- `GET /register` - Page d'inscription
- `POST /register` - Traitement de l'inscription
- `GET /nos-partenaires` - Liste publique des partenaires

### Routes Authentifiées
- `GET /dashboard` - Dashboard (nécessite connexion)
- `POST /logout` - Déconnexion

### Routes Admin
Pour protéger une route avec le middleware admin :
```php
Route::get('/admin/route', function() {
    // Code...
})->middleware(['auth', 'admin']);
```

---

## 🎯 Utilisation

### Se Connecter
1. Aller sur `http://localhost:8000/login`
2. Entrer l'email et le mot de passe
3. Cliquer sur "Se connecter"

### S'Inscrire
1. Aller sur `http://localhost:8000/register`
2. Remplir le formulaire (username, email, prénom, nom, mot de passe)
3. Le rôle "user" est automatiquement attribué
4. Connexion automatique après inscription

### Se Déconnecter
1. Depuis le dashboard, cliquer sur "Déconnexion"
2. Redirection vers la page d'accueil

---

## 🔧 Structure du Code

### Contrôleur
`app/Http/Controllers/AuthController.php`
- `showLoginForm()` - Affiche le formulaire de connexion
- `login()` - Traite la connexion
- `showRegisterForm()` - Affiche le formulaire d'inscription
- `register()` - Traite l'inscription
- `logout()` - Déconnecte l'utilisateur
- `createAdmin()` - Crée un admin (réservé aux admins)

### Middleware
`app/Http/Middleware/CheckAdmin.php`
- Vérifie que l'utilisateur est connecté
- Vérifie que l'utilisateur a le rôle admin

### Modèle User
`app/Models/User.php`
- `isAdmin()` - Vérifie si l'utilisateur est admin
- `isContributor()` - Vérifie si l'utilisateur est contributeur
- `isVisitor()` - Vérifie si l'utilisateur est visiteur
- `hasRole($roleName)` - Vérifie si l'utilisateur a un rôle spécifique
- `getFullNameAttribute()` - Retourne le nom complet

---

## 🎨 Différences selon le Rôle

### Admin
- ✅ Accès à la gestion complète des partenaires
- ✅ Accès à la gestion des types de partenaires
- ✅ Création d'événements
- ✅ Toutes les statistiques
- ✅ Badge "👑 Admin" dans le dashboard

### User
- ✅ Consultation des partenaires (vue publique)
- ✅ Consultation des événements
- ✅ Accès aux points de collecte
- ✅ Statistiques de base
- ✅ Badge "👤 Utilisateur" dans le dashboard

---

## 📝 Points Importants

1. **Pas de Seeders** : Les rôles sont créés automatiquement lors de la première inscription
2. **Sécurité** : Tous les mots de passe sont hashés avec bcrypt
3. **Validation** : Validation complète côté serveur avec messages en français
4. **Session** : Utilisation du système de session Laravel
5. **Middleware** : Protection des routes avec les middlewares `auth` et `admin`

---

## 🚀 Prochaines Étapes

Pour créer un nouvel admin manuellement :
```php
php artisan tinker

$adminRole = App\Models\Role::where('name', 'admin')->first();
$admin = App\Models\User::create([
    'username' => 'nouveau_admin',
    'email' => 'admin@example.com',
    'first_name' => 'Prénom',
    'last_name' => 'Nom',
    'password' => Hash::make('motdepasse'),
    'role_id' => $adminRole->id,
    'is_active' => true
]);
```

---

## 📞 Support

Pour toute question ou problème :
- Vérifier les logs Laravel : `storage/logs/laravel.log`
- Vérifier que le serveur est démarré : `php artisan serve`
- Vérifier les migrations : `php artisan migrate:status`
