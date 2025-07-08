# 🚀 Script d'exécution des migrations APWAP

## Prérequis
- PHP >= 8.1
- Composer installé
- Laravel installé
- Base de données configurée (PostgreSQL recommandé)

## Étapes d'exécution

### 1. Vérification de l'environnement
```bash
# Vérifier la version de PHP
php --version

# Vérifier que Laravel est installé
php artisan --version

# Vérifier la configuration de la base de données
php artisan config:cache
```

### 2. Préparation de la base de données
```bash
# Créer la base de données (si nécessaire)
# PostgreSQL
createdb apwap_db

# Ou MySQL
# mysql -u root -p -e "CREATE DATABASE apwap_db;"
```

### 3. Configuration du fichier .env
Assurez-vous que votre fichier `.env` contient les bonnes informations de connexion :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=apwap_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Exécution des migrations
```bash
# Exécuter toutes les migrations
php artisan migrate

# Ou forcer l'exécution (en cas de problème)
php artisan migrate --force

# Voir le statut des migrations
php artisan migrate:status
```

### 5. Rollback (si nécessaire)
```bash
# Annuler la dernière migration
php artisan migrate:rollback

# Annuler toutes les migrations
php artisan migrate:reset

# Réinitialiser et re-exécuter toutes les migrations
php artisan migrate:refresh
```

## 📋 Liste des migrations créées

1. **2024_01_01_000001_create_users_table.php** - Table des utilisateurs
2. **2024_01_01_000002_create_user_sessions_table.php** - Sessions utilisateurs
3. **2024_01_01_000003_create_pets_table.php** - Table des animaux
4. **2024_01_01_000004_create_pet_health_records_table.php** - Dossiers médicaux
5. **2024_01_01_000005_create_pet_vaccinations_table.php** - Vaccinations
6. **2024_01_01_000006_create_pet_medical_history_table.php** - Historique médical
7. **2024_01_01_000007_create_pet_photos_table.php** - Photos des animaux
8. **2024_01_01_000008_create_veterinarians_table.php** - Vétérinaires
9. **2024_01_01_000009_create_consultations_table.php** - Consultations
10. **2024_01_01_000010_create_consultation_availability_table.php** - Disponibilités
11. **2024_01_01_000011_create_product_categories_table.php** - Catégories produits
12. **2024_01_01_000012_create_products_table.php** - Produits
13. **2024_01_01_000013_create_product_reviews_table.php** - Avis produits
14. **2024_01_01_000014_create_carts_table.php** - Paniers
15. **2024_01_01_000015_create_cart_items_table.php** - Articles du panier
16. **2024_01_01_000016_create_orders_table.php** - Commandes
17. **2024_01_01_000017_create_order_items_table.php** - Articles de commande
18. **2024_01_01_000018_create_notifications_table.php** - Notifications
19. **2024_01_01_000019_add_foreign_key_constraints.php** - Contraintes FK
20. **2024_01_01_000020_add_check_constraints.php** - Contraintes de vérification

## 🔧 Commandes utiles

### Génération de nouveaux fichiers de migration
```bash
# Créer une nouvelle migration
php artisan make:migration create_table_name

# Créer une migration pour modifier une table existante
php artisan make:migration add_column_to_table_name --table=table_name
```

### Seeders (données de test)
```bash
# Créer un seeder
php artisan make:seeder UserSeeder

# Exécuter les seeders
php artisan db:seed

# Exécuter un seeder spécifique
php artisan db:seed --class=UserSeeder
```

### Factories (pour les tests)
```bash
# Créer une factory
php artisan make:factory UserFactory

# Créer une factory pour un modèle spécifique
php artisan make:factory PetFactory --model=Pet
```

## ⚠️ Points d'attention

1. **UUID** : Les migrations utilisent des UUID comme clés primaires pour une meilleure scalabilité
2. **PostgreSQL** : Certaines fonctionnalités utilisent des types spécifiques à PostgreSQL (JSON, INET)
3. **Index** : Les index sont optimisés pour les requêtes les plus fréquentes
4. **Contraintes** : Les contraintes de vérification assurent l'intégrité des données

## 🐛 Dépannage

### Erreur "Class not found"
```bash
composer dump-autoload
```

### Erreur de permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Problème avec les migrations
```bash
# Vérifier les migrations en attente
php artisan migrate:status

# Forcer l'exécution
php artisan migrate --force
```

## 📝 Prochaines étapes

1. Créer les modèles Eloquent correspondants
2. Configurer les relations entre les modèles
3. Créer les seeders pour les données initiales
4. Mettre en place les factories pour les tests
5. Configurer les permissions et la sécurité

---

**Note** : Ce fichier de migration respecte entièrement le schéma défini dans `database_schema.md` et est optimisé pour une application Laravel moderne.
