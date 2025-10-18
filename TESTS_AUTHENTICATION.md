# 🧪 Script de Test - Système d'Authentification

## Tests à effectuer

### 1. Test d'Inscription ✅

**Étapes:**
1. Ouvrir `http://localhost:8000/register`
2. Remplir le formulaire :
   - Username: `testuser`
   - Email: `test@example.com`
   - Prénom: `Test`
   - Nom: `User`
   - Mot de passe: `password123`
   - Confirmation: `password123`
3. Cliquer sur "S'inscrire"

**Résultat attendu:**
- ✅ Redirection vers `/dashboard`
- ✅ Message de bienvenue affiché
- ✅ Badge "👤 Utilisateur" visible
- ✅ Utilisateur automatiquement connecté

**Vérification en base:**
```bash
php artisan tinker --execute="
\$user = App\Models\User::where('email', 'test@example.com')->first();
echo 'Utilisateur: ' . \$user->username . PHP_EOL;
echo 'Rôle: ' . \$user->role->name . PHP_EOL;
"
```

---

### 2. Test de Connexion Admin ✅

**Étapes:**
1. Se déconnecter si connecté
2. Aller sur `http://localhost:8000/login`
3. Email: `admin@waste.com`
4. Mot de passe: `admin123`
5. Cliquer sur "Se connecter"

**Résultat attendu:**
- ✅ Redirection vers `/dashboard`
- ✅ Badge "👑 Admin" rouge visible
- ✅ Bouton "Gérer les Partenaires" visible
- ✅ Bouton "Types de Partenaires" visible
- ✅ Statistiques affichées correctement

---

### 3. Test de Connexion User ✅

**Étapes:**
1. Se déconnecter
2. Aller sur `http://localhost:8000/login`
3. Email: `user@waste.com`
4. Mot de passe: `user123`
5. Cliquer sur "Se connecter"

**Résultat attendu:**
- ✅ Redirection vers `/dashboard`
- ✅ Badge "👤 Utilisateur" vert visible
- ✅ Bouton "Voir les Partenaires" (pas "Gérer")
- ✅ PAS de bouton "Types de Partenaires"
- ✅ Statistiques affichées

---

### 4. Test de Protection des Routes ✅

**Test 1: Accès dashboard sans connexion**
```
1. Se déconnecter
2. Essayer d'accéder à http://localhost:8000/dashboard
```
**Résultat attendu:** Redirection vers `/login`

**Test 2: Accès admin avec compte user**
```
1. Se connecter avec user@waste.com
2. Essayer d'accéder à http://localhost:8000/partners/types
```
**Résultat attendu:** Redirection vers `/dashboard` avec message d'erreur

**Test 3: Accès admin avec compte admin**
```
1. Se connecter avec admin@waste.com
2. Accéder à http://localhost:8000/partners/types
```
**Résultat attendu:** Page accessible ✅

---

### 5. Test de Validation ✅

**Test 1: Email déjà utilisé**
```
1. Aller sur /register
2. Utiliser email: admin@waste.com
```
**Résultat attendu:** Erreur "Cette adresse email est déjà utilisée"

**Test 2: Username déjà utilisé**
```
1. Aller sur /register
2. Utiliser username: admin
```
**Résultat attendu:** Erreur "Ce nom d'utilisateur est déjà utilisé"

**Test 3: Mots de passe ne correspondent pas**
```
1. Mot de passe: password123
2. Confirmation: password456
```
**Résultat attendu:** Erreur "Les mots de passe ne correspondent pas"

**Test 4: Email invalide**
```
Email: test@invalid
```
**Résultat attendu:** Erreur "L'adresse email doit être valide"

**Test 5: Mot de passe trop court**
```
Mot de passe: 123
```
**Résultat attendu:** Erreur "Le mot de passe doit contenir au moins 6 caractères"

---

### 6. Test de Déconnexion ✅

**Étapes:**
1. Se connecter avec n'importe quel compte
2. Aller sur le dashboard
3. Cliquer sur "Déconnexion"

**Résultat attendu:**
- ✅ Redirection vers `/` (page d'accueil)
- ✅ Message "Vous avez été déconnecté avec succès"
- ✅ Impossible d'accéder au dashboard sans se reconnecter

---

### 7. Test "Se souvenir de moi" ✅

**Étapes:**
1. Se déconnecter
2. Se connecter en cochant "Se souvenir de moi"
3. Fermer le navigateur
4. Rouvrir le navigateur
5. Aller sur `http://localhost:8000/dashboard`

**Résultat attendu:** Toujours connecté ✅

---

### 8. Test des Statistiques ✅

**Dashboard Admin:**
```
- Nombre d'objets valorisables (dynamique)
- Nombre de partenaires actifs (dynamique)
- Nombre de points de collecte (dynamique)
- Nombre d'événements à venir (dynamique)
```

**Vérification:**
```bash
php artisan tinker --execute="
echo 'Items: ' . App\Models\Item::count() . PHP_EOL;
echo 'Partners: ' . App\Models\Partner::count() . PHP_EOL;
echo 'Collection Points: ' . App\Models\CollectionPoint::count() . PHP_EOL;
echo 'Events à venir: ' . App\Models\Event::where('date', '>=', now())->count() . PHP_EOL;
"
```

---

## 🐛 Erreurs à Ignorer

### ❌ Erreurs Chrome Extension (NORMALES)
```
GET chrome-extension://pejdijmoenmkgeppbflobdenhhabjlaj/...
```
**Cause:** Extensions Chrome (gestionnaire de mots de passe)  
**Impact:** Aucun - Ignorez ces messages  
**Solution:** Filtrer avec `-chrome-extension` dans la console

---

## ✅ Checklist Complète

- [x] Inscription fonctionne
- [x] Connexion admin fonctionne
- [x] Connexion user fonctionne
- [x] Déconnexion fonctionne
- [x] Dashboard personnalisé selon rôle
- [x] Middleware auth protège les routes
- [x] Middleware admin protège les routes admin
- [x] Validation des formulaires
- [x] Messages d'erreur en français
- [x] Statistiques dynamiques
- [x] Création automatique des rôles
- [x] Hachage des mots de passe
- [x] Protection CSRF

---

## 📊 Commandes Utiles

### Voir tous les utilisateurs
```bash
php artisan tinker --execute="App\Models\User::with('role')->get()->each(fn(\$u) => print(\$u->email . ' - ' . \$u->role->name . PHP_EOL));"
```

### Créer un nouvel admin
```bash
php artisan tinker --execute="
\$role = App\Models\Role::where('name', 'admin')->first();
App\Models\User::create([
    'username' => 'newadmin',
    'email' => 'newadmin@example.com',
    'first_name' => 'New',
    'last_name' => 'Admin',
    'password' => Hash::make('password'),
    'role_id' => \$role->id,
    'is_active' => true
]);
echo 'Admin créé!';
"
```

### Supprimer un utilisateur
```bash
php artisan tinker --execute="App\Models\User::where('email', 'test@example.com')->delete();"
```

### Réinitialiser la base de données
```bash
php artisan migrate:fresh
# Puis recréer les utilisateurs de test
```

---

**Status:** ✅ Tous les tests passent  
**Date:** 17 octobre 2025  
**Version:** 1.0
