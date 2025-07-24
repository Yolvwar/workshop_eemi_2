# **APWAP – Luxury Pet Care Platform**

Plateforme haut de gamme combinant un **dashboard personnalisé**, un **e-commerce spécialisé** et un **espace de gestion vétérinaire** pour chiens et chats.

---

## **Installation Rapide (≈ 2 minutes)**

### **Prérequis**
- **Docker Desktop** installé et en cours d’exécution
- **Git** installé
- **Composer** et **NPM** installés globalement

---

### **Étapes d’installation**

#### **Windows (PowerShell)**
```powershell
# 1. Cloner le projet
git clone <repository-url>
cd apwap

# 2. Copier le fichier d'environnement
copy .env.example .env

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

#### **Linux / macOS**
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

**Accès local :**
- Application : [http://localhost](http://localhost)
- Base de données : PostgreSQL sur `localhost:5432`
- Données de test : incluses automatiquement

---

## **Dépannage**

### **Windows – Utilisation de WSL2 recommandée**
```bash
cd /mnt/c/Users/Example/path/projet_cloner/
./vendor/bin/sail up -d
```

### **Erreurs fréquentes :**
- **Permission denied (Linux/macOS)**  
```bash
chmod +x vendor/bin/sail
./vendor/bin/sail up -d
```
- **Port 80 occupé**  
Modifier dans `.env` :  
```env
APP_PORT=8080
```
Puis redémarrer :  
```bash
./vendor/bin/sail down
./vendor/bin/sail up -d
```

- **Réinitialisation complète**  
```bash
./vendor/bin/sail down --volumes
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:fresh --seed
```

---

## **Fonctionnalités principales**

### **Dashboard**
- Vue d’ensemble avec métriques en temps réel
- Indicateurs de bien-être des animaux (6 piliers)
- Système d’alertes et rappels personnalisés

### **Gestion des animaux**
- Profils complets avec photos et historique médical
- Suivi des vaccinations et soins

### **E-commerce**
- Catalogue premium de +65 produits et 21 catégories
- Système de panier, commandes et avis clients

### **Consultations**
- Prise de rendez-vous en ligne
- Gestion des vétérinaires et suivi des diagnostics

---

## **Commandes utiles**
```bash
# Voir les logs
./vendor/bin/sail logs

# Accéder au container
./vendor/bin/sail bash

# Artisan
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan tinker

# Arrêter l'environnement
./vendor/bin/sail down
```

---

## **Base de données**
- **PostgreSQL 15** avec Docker
- **18 tables** principales
- **Migrations versionnées** et **seeders** intégrés

Accès direct :  
```bash
./vendor/bin/sail psql
```

---

## **Stack technique**
- **Laravel 11.x** – Framework PHP
- **PostgreSQL** – Base de données
- **Docker Sail** – Environnement de développement
- **Tailwind CSS** – Styles minimalistes
- **Blade Components** – Interface modulaire

---

## **Arborescence**
```
apwap/
├── app/Models/           # Modèles (User, Pet, Product, Order…)
├── app/Http/Controllers/ # Contrôleurs
├── resources/views/      # Vues Blade
├── database/migrations/  # Migrations
├── database/seeders/     # Données de test
└── routes/web.php        # Routes
```

---

## **Contribution**
1. Forker le projet  
2. Créer une branche : `git checkout -b feature/ma-feature`  
3. Committer : `git commit -m 'Add ma feature'`  
4. Pousser : `git push origin feature/ma-feature`  
5. Ouvrir une Pull Request

---

## **Licence**
Ce projet est distribué sous licence **MIT**.
