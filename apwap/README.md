# 🐾 APWAP - Luxury Pet Care Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/PostgreSQL-15-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Docker-Sail-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

## 🌟 À propos d'APWAP

APWAP (Luxury Pet Care) est une plateforme complète dédiée au bien-être des animaux de compagnie haut de gamme aux Émirats Arabes Unis. L'application combine soins vétérinaires, e-commerce spécialisé et suivi personnalisé basé sur 6 piliers fondamentaux.

### 🎯 Modules principaux

- **🏠 Dashboard** - Tableau de bord personnalisé avec scores des 6 piliers
- **🐕 Gestion des animaux** - Profils détaillés, historique médical, photos
- **👨‍⚕️ Consultations vétérinaires** - Rendez-vous, téléconsultations, suivi
- **🛒 Boutique e-commerce** - Produits spécialisés, recommandations IA
- **⚙️ Profil utilisateur** - Paramètres, préférences, membership

### 🏗️ Architecture technique

- **Backend** : Laravel 11.x avec Eloquent ORM
- **Base de données** : PostgreSQL avec support JSON et UUID
- **Containerisation** : Docker avec Laravel Sail
- **Cache** : Redis pour les performances
- **Stockage** : Support AWS S3 pour les fichiers
- **API** : RESTful avec authentification JWT

## 🚀 Installation & Setup

### 📋 Prérequis

- **Docker** et **Docker Compose** installés
- **Git** pour cloner le projet
- **WSL2** (pour Windows) ou Linux/macOS

### 🔧 Installation rapide

```bash
# 1. Cloner le projet
git clone <repository-url>
cd apwap

# 2. Copier le fichier d'environnement
cp .env.example .env

# 3. Installer les dépendances via Sail
./vendor/bin/sail up -d
./vendor/bin/sail composer install

# 4. Générer la clé d'application
./vendor/bin/sail artisan key:generate

# 5. Exécuter les migrations
./vendor/bin/sail artisan migrate:refresh

# 6. (Optionnel) Exécuter les seeders
./vendor/bin/sail artisan db:seed
```

### ⚙️ Configuration de l'environnement

Modifiez le fichier `.env` avec vos paramètres :

```env
# Base de données
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=apwap
DB_USERNAME=sail
DB_PASSWORD=password

# Application
APP_NAME="APWAP"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

# Timezone pour les EAU
APP_TIMEZONE=Asia/Dubai
```

### 🐳 Commandes Docker Sail

```bash
# Démarrer les conteneurs
./vendor/bin/sail up -d

# Arrêter les conteneurs
./vendor/bin/sail down

# Voir les logs
./vendor/bin/sail logs

# Accéder au container de l'application
./vendor/bin/sail bash

# Exécuter des commandes Artisan
./vendor/bin/sail artisan <command>
```

## 🗄️ Base de données

### 📊 Schéma de données

Le projet utilise un schéma complet avec **18 tables principales** :

**👥 Utilisateurs**
- `users` - Comptes utilisateurs
- `user_sessions` - Sessions actives

**🐾 Animaux**
- `pets` - Profils des animaux
- `pet_health_records` - Dossiers médicaux
- `pet_vaccinations` - Historique vaccinations
- `pet_medical_history` - Historique médical
- `pet_photos` - Photos des animaux

**👨‍⚕️ Consultations**
- `veterinarians` - Profils vétérinaires
- `consultations` - Rendez-vous
- `consultation_availability` - Disponibilités

**🛒 E-commerce**
- `product_categories` - Catégories produits
- `products` - Catalogue produits
- `product_reviews` - Avis clients
- `carts` - Paniers d'achat
- `cart_items` - Articles du panier
- `orders` - Commandes
- `order_items` - Articles commandés

**🔔 Notifications**
- `notifications` - Messages système

### 🔧 Gestion des migrations

```bash
# Voir le statut des migrations
./vendor/bin/sail artisan migrate:status

# Exécuter les migrations
./vendor/bin/sail artisan migrate

# Rollback des migrations
./vendor/bin/sail artisan migrate:rollback

# Réinitialiser la base de données
./vendor/bin/sail artisan migrate:refresh
```

### 🔍 Accès à la base de données

```bash
# Via psql
./vendor/bin/sail psql

# Via Tinker
./vendor/bin/sail artisan tinker

# Commandes SQL utiles
\dt                    # Lister les tables
\d nom_table          # Structure d'une table
\d+ nom_table         # Détails complets
SELECT * FROM users;  # Exemple de requête
```

## 📁 Structure du projet

```
apwap/
├── app/
│   ├── Http/Controllers/     # Contrôleurs
│   ├── Models/              # Modèles Eloquent
│   ├── Services/            # Services métier
│   └── ...
├── database/
│   ├── migrations/          # Migrations de base de données
│   ├── seeders/            # Données initiales
│   └── factories/          # Factories pour tests
├── resources/
│   ├── views/              # Vues Blade
│   ├── js/                 # JavaScript
│   └── css/                # Styles
├── routes/
│   ├── web.php             # Routes web
│   └── api.php             # Routes API
└── documentation/          # Documentation projet
```

## 📋 Processus de contribution

### Branches

Le projet utilise **Git Flow** avec la structure suivante :

- **`main`** - Branche de production (stable, déployée)
- **`develop`** - Branche de développement (intégration des features)
- **`feature/*`** - Branches pour les nouvelles fonctionnalités

### Contribuer

1. **Fork** le projet sur GitHub
2. **Cloner** votre fork localement
   ```bash
   git clone https://github.com/votre-username/apwap.git
   cd apwap
   ```

3. **Configurer** les remotes
   ```bash
   git remote add upstream https://github.com/original-repo/apwap.git
   ```

4. **Créer** une branche feature depuis `develop`
   ```bash
   git checkout develop
   git pull upstream develop
   git checkout -b feature/nom_features
   ```

5. **Développer** votre fonctionnalité
   ```bash
   # Faire vos modifications
   git add .
   git commit -m "feat: add amazing feature"
   ```

6. **Synchroniser** avec develop régulièrement
   ```bash
   git fetch upstream
   git rebase upstream/develop
   ```

7. **Pousser** votre branche
   ```bash
   git push origin feature/amazing-feature
   ```

8. **Créer** une Pull Request
   - Depuis votre branche `feature/amazing-feature`
   - Vers la branche `develop` du projet principal
   - Avec une description détaillée des changements

### ⚠️ Règles importantes

- **❌ Ne jamais pusher directement sur `main`**
- **❌ Ne jamais pusher directement sur `develop`**
- **✅ Toujours créer une Pull Request**
- **✅ Attendre la validation avant merge**
- **✅ Tester localement avant de pousser**

### 📝 Conventions de commit

Utilisez les conventions **Conventional Commits** :

```bash
feat: nouvelle fonctionnalité
fix: correction de bug
docs: modification de documentation
style: changements de style (formatting, etc.)
refactor: refactoring du code
```