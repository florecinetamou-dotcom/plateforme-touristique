# 🇧🇯 Tourisme Bénin - Plateforme de Réservation

## 📋 Description
Plateforme de réservation touristique pour le Bénin.
Gestion des hébergements, sites touristiques, réservations et chatbot.

## 🗄️ Base de données
- **SGBD** : MySQL 5.7+ / MariaDB 10.2+
- **Charset** : utf8mb4_unicode_ci
- **Structure** : Migrations SQL pures
- **Gestionnaire** : PHP CLI (migrate.php)

## 🚀 Installation rapide

```bash
# 1. Cloner le projet
git clone https://github.com/votre-repo/tourisme-benin.git

# 2. Configurer l'environnement
cp .env.example .env
nano .env  # Modifier DB_USER et DB_PASS

# 3. Créer la base et exécuter les migrations
php database/migrate.php

# 4. Importer les données de test
php database/seed.php

# 5. Tester la base
mysql -u root -p benin_tourisme < tests/queries/test_reservations.sql