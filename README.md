# 🐾 APWAP - Luxury Pet Care Platform

Plateforme complète de soins pour animaux de compagnie combinant dashboard personnalisé, e-commerce spécialisé et gestion vétérinaire.

## 🚀 Installation ultra-rapide (2 minutes)

### Prérequis
- **Docker Desktop** installé et démarré
- **Git** installé
- **Composer&Npm** installé globalement

### Installation

#### Sur Windows (PowerShell)
```powershell
# 1. Cloner le projet
git clone <repository-url>
cd apwap

# 2. Copier le fichier d'environnement
copy .env.example .env

# 3. Installer les dépendances
composer install
npm install

# 4. Démarrer l'environnement Docker ( si vous rencontrez des problèmes à cette étape en tant qu'utilisateur Windows aller à la section dépannage)
./vendor/bin/sail up -d

# 5. Configurer l'application
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail npm run dev

```

#### Sur Linux/macOS
```bash
# 1. Cloner le projet
git clone <repository-url>
cd apwap

# 2. Copier le fichier d'environnement
cp .env.example .env

# 3. Installer les dépendances
composer install
npm install

# 4. Démarrer l'environnement Docker
./vendor/bin/sail up -d

# 5. Configurer l'application
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail npm run dev
```

**C'est fini !** 

- **Site web** : http://localhost
- **Base de données** : PostgreSQL sur localhost:5432
- **Données de test** : Incluses automatiquement

## 🆘 Dépannage

```

### ⚠️ Si ça ne fonctionne pas sur Windows
**Solution recommandée : Utilisez WSL2**

1. Ouvre **Ubuntu** (ou ta distribution WSL)
2. Navigate vers ton projet :
```bash
cd /mnt/c/Users/Example/path/projet_cloner/
```
3. Lance Sail depuis WSL :
```bash
./vendor/bin/sail up -d
```

> **💡 Pourquoi WSL ?** Laravel Sail nécessite WSL2 ou un environnement Linux, car Sail utilise Docker sous un shell bash.

### Erreur "Permission denied" (Linux/macOS)
```bash
# Donner les permissions d'exécution
chmod +x vendor/bin/sail
./vendor/bin/sail up -d
```

### Port déjà utilisé
```bash
# Si le port 80 est occupé, modifier dans .env :
APP_PORT=8080

# Puis redémarrer
./vendor/bin/sail down
./vendor/bin/sail up -d
```

### Réinitialiser complètement
```bash
# En cas de problème, tout nettoyer :
./vendor/bin/sail down --volumes
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:fresh --seed
```

## 📱 Fonctionnalités

### 🏠 Dashboard
- Tableau de bord avec métriques en temps réel
- Scores de bien-être des animaux (6 piliers)
- Alertes et rappels intelligents

### 🐕 Gestion des animaux
- Profils détaillés avec photos
- Historique médical complet
- Suivi des vaccinations

### 🛒 E-commerce
- Boutique avec 65+ produits
- 21 catégories spécialisées
- Panier et commandes
- Reviews et notes

### 👨‍⚕️ Consultations
- Prise de rendez-vous
- Gestion des vétérinaires
- Suivi médical

## �️ Commandes utiles

```bash
# Voir les logs
./vendor/bin/sail logs

# Accéder au container
./vendor/bin/sail bash

# Artisan commands
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan tinker

# Arrêter l'environnement
./vendor/bin/sail down
```

## �️ Base de données

- **PostgreSQL** avec Docker
- **18 tables** principales
- **Seeders** pour données de test
- **Migrations** versionnées

### Accès direct à la DB
```bash
./vendor/bin/sail psql
```

## 🏗️ Stack technique

- **Laravel 11.x** - Framework PHP
- **PostgreSQL 15** - Base de données
- **Docker Sail** - Environnement
- **Tailwind CSS** - Styles
- **Blade Components** - Interface modulaire

## � Structure

```
apwap/
├── app/Models/          # Modèles (User, Pet, Product, Order...)
├── app/Http/Controllers/ # Contrôleurs
├── resources/views/     # Vues Blade
├── database/migrations/ # Migrations DB
├── database/seeders/    # Données de test
└── routes/web.php       # Routes
```

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/ma-feature`)
3. Commiter (`git commit -m 'Add ma feature'`)
4. Pusher (`git push origin feature/ma-feature`)
5. Ouvrir une Pull Request

## 📄 License

Ce projet est sous license MIT.
