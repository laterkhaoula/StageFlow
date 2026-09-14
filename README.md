# StageFlow

Plateforme web de recherche de stages et de gestion des candidatures.

Développée dans le cadre d'un projet Fil Rouge Full-Stack (2026). **Projet terminé et prêt pour la validation fonctionnelle finale.**

---

## Description du projet

**StageFlow** centralise la recherche de stages et la gestion des candidatures sur une seule plateforme.

**Problème résolu :** les étudiants doivent chercher des offres de stage dispersées et gérer leurs candidatures sans suivi, tandis que les entreprises peinent à diffuser leurs offres et à suivre les candidatures reçues.

**Utilisateurs cibles :**

| Utilisateur | Besoin |
|-------------|--------|
| Étudiant | Rechercher des offres actives, déposer et suivre ses candidatures |
| Entreprise | Publier et gérer ses offres, gérer les candidatures reçues |
| Administrateur | Superviser la plateforme (utilisateurs, offres, candidatures, statistiques) |

**Fonctionnement principal :** une entreprise publie une offre ; un étudiant connecté la consulte et y dépose une candidature avec un message de motivation ; l'entreprise accepte ou refuse la candidature ; l'étudiant suit le statut et reçoit des notifications à chaque étape. L'administrateur supervisie l'ensemble.

---

## Technologies

- **Backend :** Laravel 13 / PHP 8.3
- **ORM :** Eloquent
- **Frontend :** Blade (server-side rendering)
- **Base de données :** MySQL 8.0
- **Authentification :** Laravel Breeze
- **Gestion des rôles :** Laratrust
- **CSS :** Tailwind CSS
- **JS :** Alpine.js / Vite
- **Conteneurisation :** Docker / Docker Compose
- **Tests :** PHPUnit

---

## Architecture

Le projet suit l'architecture **MVC classique Laravel** avec des vues **Blade** côté serveur.

```
app/
├── Http/Controllers/    # Contrôleurs
├── Http/Middleware/      # Middleware (RoleMiddleware)
├── Http/Requests/       # Form Requests (validation)
├── Models/              # Modèles Eloquent
├── Notifications/       # Notifications Laravel
└── Policies/            # Politiques d'autorisation
resources/views/         # Vues Blade
routes/                  # Routes web
database/migrations/     # Migrations MySQL
tests/                   # Tests PHPUnit
```

---

## Rôles

| Rôle | Description |
|------|-------------|
| `etudiant` | Recherche des offres, dépose des candidatures, gère son profil et son CV |
| `entreprise` | Publie des offres, gère les candidatures reçues, gère son profil |
| `administrateur` | Supervise la plateforme (utilisateurs, offres, candidatures, statistiques) |

---

## Fonctionnalités principales

- **Authentification :** Laravel Breeze (inscription, connexion, déconnexion, réinitialisation du mot de passe, vérification e-mail, gestion du profil) et redirection selon le rôle.
- **Rôles et permissions :** Laratrust avec `RoleMiddleware` (rôles Laratrust prioritaires + fallback `users.role`).
- **Offres :** consultation des offres actives, recherche par mot-clé / domaine / localisation, détail, création et modification par l'entreprise, activation / désactivation, suppression — protection par policies.
- **Candidatures :** dépôt par l'étudiant (double candidature et offre inactive bloquées), liste de ses candidatures, candidatures reçues côté entreprise, acceptation / refus avec historique des changements de statut et notifications.
- **CV :** accessibles uniquement via des routes protégées (`student-profile.cv`, `candidatures.company.cv`), jamais en accès public.
- **Notifications :** système de notifications Laravel paginé (nouvelle candidature, changement de statut).
- **Dashboards :** étudiant, entreprise et administrateur avec statistiques isolées par rôle.
- **Administration :** consultation des utilisateurs, des offres et des candidatures.

---

## Sécurité

La sécurité est appliquée **côté serveur**, jamais uniquement dans l'interface :

* **Authentification :** Laravel Breeze (`auth`, vérification e-mail, sessions en base de données).
* **Rôles :** `RoleMiddleware` — rôles Laratrust prioritaires avec fallback sur `users.role` ; toute tentative d'accès à une route d'un autre rôle renvoie une **403**.
* **Policies :** `OffrePolicy` (une entreprise ne modifie que ses propres offres), `CandidaturePolicy` (une entreprise ne gère que les candidatures de ses propres offres), `StudentProfilePolicy` (un étudiant ne gère que son propre profil).
* **Validation :** Form Requests (`StoreOffreRequest`, `UpdateOffreRequest`, `StoreCandidatureRequest`) + validations Breeze ; aucune confiance accordée au seul frontend.
* **CV protégés :** stockés sur un **disque privé**, téléchargeables uniquement via des routes authentifiées et autorisées (`student-profile.cv`, `candidatures.company.cv`) ; jamais exposés via `Storage::url()`.
* **Règles métier :** double candidature à la même offre bloquée, candidature à une offre inactive bloquée.
* **Protections Laravel :** CSRF, mots de passe hashés, échappement automatique Blade (anti-XSS), requêtes Eloquent (anti-injection SQL).

---

## Installation

### Prérequis

- Docker et Docker Compose
- Git

### Étapes

```bash
# Cloner le projet
git clone <url-du-depot>
cd StageFlow

# Installer les dépendances PHP
composer install

# Installer les dépendances Node.js
npm install

# Construire les assets frontend
npm run build

# Démarrer les conteneurs Docker
docker compose up -d

# Générer la clé d'application
docker compose exec app php artisan key:generate

# Exécuter les migrations
docker compose exec app php artisan migrate --force

# (Optionnel) Lien de stockage public
# Non requis pour le fonctionnement (les CV sont stockés sur un disque privé)
docker compose exec app php artisan storage:link

# (Optionnel) Seeder les rôles
docker compose exec app php artisan db:seed
```

---

## Lancement

```bash
docker compose up -d
```

L'application est accessible sur : **http://localhost:8001**

---

## Base de données (Docker)

| Paramètre | Valeur |
|-----------|--------|
| Hôte | `mysql` (container) / `localhost` (hôte) |
| Port | `3308` |
| Nom | `stageflow` |
| Utilisateur | `stageflow` |
| Mot de passe | `stageflow_password` |

---

## Commandes Laravel utiles

```bash
# Exécuter une commande artisan dans le conteneur
docker compose exec app php artisan <commande>

# Démarrer le serveur de développement (sans Docker)
php artisan serve

# Exécuter les migrations
php artisan migrate --force

# Seeder la base
php artisan db:seed

# Créer un symlink de stockage
php artisan storage:link

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Tests

```bash
# Exécuter tous les tests
docker compose exec app php artisan test

# Ou sans Docker
php artisan test

# Tests spécifiques
php artisan test --filter=RoleMiddlewareTest
php artisan test --filter=OffreManagementTest
php artisan test --filter=CandidatureSubmissionTest
php artisan test --filter=CvSecurityTest
```

Le projet contient **78 tests / 209 assertions** couvrant notamment :

* l'authentification (inscription, connexion, vérification e-mail, mot de passe, profil) ;
* la gestion des rôles et des accès par rôle (`RoleMiddleware`) ;
* la consultation des offres (recherche, filtres, offres actives uniquement) ;
* la gestion des offres par l'entreprise (création, modification, suppression, activation / désactivation, isolation entre entreprises) ;
* le dépôt de candidatures (double candidature bloquée, offre inactive bloquée, notification à l'entreprise) ;
* la gestion des candidatures côté entreprise (acceptation, refus, historique, notification à l'étudiant) ;
* la sécurité des CV (routes protégées, accès restreint) ;
* les dashboards étudiant, entreprise et administrateur ;
* les notifications (liste paginée, lecture).

---

## Structure des routes principales

| Route | Méthode | Accès | Description |
|-------|---------|-------|-------------|
| `/` | GET | Public | Page d'accueil |
| `/login` `/register` | GET/POST | Public | Connexion / inscription |
| `/dashboard` | GET | Étudiant | Tableau de bord étudiant |
| `/offres` | GET | Authentifié | Offres actives (recherche / filtres) |
| `/offres/{offre}` | GET | Authentifié | Détail d'une offre |
| `/candidatures` | GET/POST | Étudiant | Mes candidatures / dépôt d'une candidature |
| `/student-profile` | GET/PUT | Étudiant | Profil étudiant (+ CV privé via `/student-profile/cv`) |
| `/company-dashboard` | GET | Entreprise | Tableau de bord entreprise |
| `/company-profile` | GET/PUT | Entreprise | Profil entreprise |
| `/mes-offres` | GET/POST | Entreprise | Liste / création d'offres |
| `/mes-offres/{offre}` | GET/PUT/DELETE | Entreprise | Modifier / supprimer une offre |
| `/mes-offres/{offre}/statut` | PUT | Entreprise | Activer / désactiver une offre |
| `/mes-candidatures` | GET | Entreprise | Candidatures reçues |
| `/mes-candidatures/{id}` | GET | Entreprise | Détail d'une candidature |
| `/mes-candidatures/{id}/accept` `/refuse` | POST | Entreprise | Accepter / refuser |
| `/mes-candidatures/{id}/cv` | GET | Entreprise | Télécharger le CV du candidat |
| `/admin-dashboard` | GET | Admin | Dashboard et statistiques |
| `/admin/users` | GET | Admin | Liste des utilisateurs |
| `/admin/offres` | GET | Admin | Liste des offres |
| `/admin/candidatures` | GET | Admin | Liste des candidatures |
| `/notifications` | GET | Authentifié | Liste des notifications |
| `/notifications/{id}/read` | POST | Authentifié | Marquer une notification comme lue |
| `/profile` | GET/PATCH/DELETE | Authentifié | Profil / mot de passe / suppression du compte |

---

## Comptes de démonstration

Il n'existe **aucun compte de démonstration pré-créé** dans le projet.

* **Étudiant / Entreprise :** créer un compte via la page `/register`. Le rôle est choisi au moment de l'inscription (liste restreinte à `etudiant` et `entreprise`) ; un profil vide est créé automatiquement et peut être complété depuis l'application.
* **Administrateur :** le rôle `administrateur` ne peut **pas** être choisi à l'inscription. Pour disposer d'un compte administrateur, créer l'utilisateur puis lui assigner le rôle, par exemple via `docker compose exec app php artisan tinker` (création d'un utilisateur + liaison avec le rôle `administrateur` de Laratrust).

---

## Licence

Projet de développement — Usage académique.
