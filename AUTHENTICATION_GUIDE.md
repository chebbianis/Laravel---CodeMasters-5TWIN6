# 🔐 Guide d'Authentification - Waste To Product

## 📋 Vue d'ensemble

Le système d'authentification complet a été implémenté avec :
- ✅ Inscription utilisateur
- ✅ Connexion/Déconnexion
- ✅ Gestion des rôles (Admin & User)
- ✅ Protection des routes
- ✅ Middleware d'authentification

---

## 👥 Comptes de Test

### 👑 Compte Administrateur
- **Email:** `admin@waste.com`
- **Mot de passe:** `admin123`
- **Accès:** Tous les modules avec privilèges complets

### 👤 Compte Utilisateur Standard
- **Email:** `user@waste.com`
- **Mot de passe:** `user123`
- **Accès:** Consultation et fonctionnalités limitées

---

## 🎯 Fonctionnalités Implémentées

### 1. Inscription (`/register`)
- Création automatique du rôle "user" si inexistant
- Validation complète des données :
  - Nom d'utilisateur unique
  - Email unique et valide
  - Prénom et nom obligatoires
  - Mot de passe minimum 6 caractères
  - Confirmation de mot de passe
- Connexion automatique après inscription
- Messages d'erreur en français

### 2. Connexion (`/login`)
- Authentification par email et mot de passe
- Option "Se souvenir de moi"
- Mise à jour de la dernière connexion
- Redirection vers le dashboard après connexion
- Gestion des erreurs de connexion

### 3. Déconnexion (`POST /logout`)
- Invalidation de la session
- Régénération du token CSRF
- Redirection vers la page d'accueil

### 4. Dashboard (`/dashboard`)
- Protégé par middleware `auth`
- Affichage personnalisé selon le rôle
- Statistiques en temps réel :
  - Nombre d'objets valorisables
  - Nombre de partenaires actifs
  - Nombre de points de collecte
  - Nombre d'événements à venir
- Actions rapides adaptées au rôle
- Informations du profil utilisateur

---

## 🔒 Système de Rôles

### Rôle Admin
**Privilèges:**
- Gestion complète des partenaires (CRUD)
- Gestion des types de partenaires
- Création d'événements
- Accès à toutes les statistiques
- Gestion des utilisateurs (à venir)

**Badge Dashboard:** 👑 Admin (rouge)

### Rôle User
**Privilèges:**
- Consultation des partenaires publics
- Participation aux événements
- Dépôt d'objets valorisables
- Accès aux points de collecte

**Badge Dashboard:** 👤 Utilisateur (vert)

---

## 🛡️ Middleware de Protection

### Middleware `auth`
- Vérifie que l'utilisateur est connecté
- Utilisé sur `/dashboard` et autres routes protégées
- Redirige vers `/login` si non connecté

### Middleware `admin`
- Vérifie que l'utilisateur est connecté ET admin
- Utilisé pour les routes d'administration
- Redirige vers `/dashboard` avec message d'erreur si non admin

**Utilisation dans les routes:**
```php
Route::get('/admin-only', function () {
    return view('admin.page');
})->middleware(['auth', 'admin']);
```

---

## 📁 Structure des Fichiers

### Contrôleur
```
app/Http/Controllers/AuthController.php
├── showLoginForm()       # Affiche le formulaire de connexion
├── login()              # Traite la connexion
├── showRegisterForm()   # Affiche le formulaire d'inscription
├── register()           # Traite l'inscription
├── logout()             # Déconnexion
└── createAdmin()        # Créer un admin (réservé aux admins)
```

### Middleware
```
app/Http/Middleware/CheckAdmin.php
└── handle()  # Vérifie le rôle admin
```

### Vues
```
resources/views/auth/
├── login.blade.php      # Formulaire de connexion
└── register.blade.php   # Formulaire d'inscription
```

### Routes
```php
// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protégées
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
```

---

## 🔧 Modèle User

### Méthodes Utilitaires

```php
// Vérifier les rôles
Auth::user()->isAdmin()        // true si admin
Auth::user()->isContributor()  // true si contributeur
Auth::user()->isVisitor()      // true si visiteur
Auth::user()->hasRole('admin') // Vérifier un rôle spécifique

// Obtenir le nom complet
Auth::user()->full_name  // "Prénom Nom"

// Relations
Auth::user()->role              // Rôle de l'utilisateur
Auth::user()->items             // Objets créés
Auth::user()->partners          // Partenaires créés
Auth::user()->participations    // Participations aux événements
```

---

## 🎨 Utilisation dans les Vues Blade

### Vérifier l'authentification
```blade
@auth
    <p>Bonjour {{ Auth::user()->first_name }} !</p>
@endauth

@guest
    <a href="{{ route('login') }}">Se connecter</a>
@endguest
```

### Vérifier le rôle
```blade
@if(Auth::user()->isAdmin())
    <a href="/admin/dashboard">Administration</a>
@else
    <a href="/user/profile">Mon Profil</a>
@endif
```

### Affichage conditionnel selon le rôle
```blade
@auth
    @if(Auth::user()->isAdmin())
        <!-- Contenu admin -->
        <button>Gérer les partenaires</button>
    @else
        <!-- Contenu utilisateur standard -->
        <button>Voir les partenaires</button>
    @endif
@endauth
```

---

## 🔐 Sécurité

### Mesures de Sécurité Implémentées

1. **Hachage des mots de passe**
   - Utilisation de `Hash::make()` pour le stockage
   - Bcrypt par défaut (sécurisé)

2. **Protection CSRF**
   - Token `@csrf` dans tous les formulaires
   - Validation automatique par Laravel

3. **Validation des données**
   - Validation côté serveur stricte
   - Messages d'erreur personnalisés en français
   - Vérification de l'unicité (email, username)

4. **Gestion des sessions**
   - Régénération du token à la connexion
   - Invalidation complète à la déconnexion
   - Option "Se souvenir de moi" sécurisée

5. **Middleware de protection**
   - Vérification de l'authentification
   - Contrôle des permissions par rôle
   - Redirection automatique

---

## 📊 Base de Données

### Table `roles`
```
- id (PK)
- name (unique, ex: 'admin', 'user')
- description
- permissions (nullable)
- timestamps
```

### Table `users`
```
- id (PK)
- username (unique)
- email (unique)
- password (hashed)
- first_name
- last_name
- role_id (FK -> roles)
- last_login (datetime, nullable)
- is_active (boolean, default: true)
- timestamps
```

---

## 🚀 Tester le Système

### 1. Inscription d'un nouvel utilisateur
```
1. Aller sur http://localhost:8000/register
2. Remplir le formulaire
3. Cliquer sur "S'inscrire"
4. Redirection automatique vers le dashboard
```

### 2. Connexion avec compte existant
```
1. Aller sur http://localhost:8000/login
2. Utiliser admin@waste.com / admin123 (admin)
   ou user@waste.com / user123 (user)
3. Cliquer sur "Se connecter"
4. Accès au dashboard avec permissions correspondantes
```

### 3. Tester les permissions
```
Admin:
- Accéder à http://localhost:8000/partners/types ✅
- Voir le bouton "Gérer les Partenaires" ✅
- Créer/modifier/supprimer des partenaires ✅

User:
- Accéder à http://localhost:8000/partners/types ❌ (redirection)
- Voir le bouton "Voir les Partenaires" ✅
- Consultation uniquement ✅
```

---

## 🐛 Dépannage

### Problème: "Token mismatch"
**Solution:** Vider le cache du navigateur et réessayer

### Problème: "Route [login] not defined"
**Solution:** Vérifier que les routes sont bien définies dans `web.php`

### Problème: "Call to undefined method isAdmin()"
**Solution:** Vérifier que la méthode existe dans `app/Models/User.php`

### Problème: Redirection infinie
**Solution:** Vérifier que le middleware `auth` n'est pas appliqué sur `/login` ou `/register`

---

## 📝 Notes Importantes

1. **Pas de seeders utilisés** - Les rôles sont créés automatiquement lors de la première inscription
2. **Rôle par défaut** - Nouveau utilisateur = rôle "user" automatiquement
3. **Admin initial** - Créé manuellement via Tinker (voir comptes de test)
4. **Sécurité** - Ne jamais commiter les mots de passe en dur dans le code
5. **Production** - Changer les mots de passe par défaut en production

---

## 🎯 Prochaines Étapes Possibles

- [ ] Page de profil utilisateur avec modification
- [ ] Récupération de mot de passe oublié
- [ ] Vérification d'email
- [ ] Système de permissions plus granulaire
- [ ] Journalisation des actions utilisateurs
- [ ] Interface d'administration des utilisateurs (pour les admins)
- [ ] Tableau de bord personnalisé par rôle
- [ ] API REST avec authentification JWT

---

## 📞 Support

En cas de problème, vérifier :
1. La base de données est bien migrée (`php artisan migrate`)
2. Les comptes de test existent
3. Le serveur Laravel est lancé (`php artisan serve`)
4. Les routes sont bien définies (`php artisan route:list`)

---

**Date de création:** 17 octobre 2025  
**Version:** 1.0  
**Projet:** Waste To Product - Système d'Authentification
