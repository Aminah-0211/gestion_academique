# GUIDE D'INSTALLATION
## Gestion Académique - SupTech Business School

---

## 📋 Table des matières

1. [Prérequis](#prérequis)
2. [Installation locale](#installation-locale)
3. [Configuration](#configuration)
4. [Création de la base de données](#création-de-la-base-de-données)
5. [Vérifications](#vérifications)
6. [Démarrage de l'application](#démarrage-de-lapplication)
7. [Dépannage](#dépannage)

---

## 🔧 Prérequis

### Système d'exploitation
- Windows 10+ ou macOS 10.13+ ou Linux (Ubuntu 18.04+)

### Logiciels requis
- **PHP** : 8.0 ou supérieur
- **MySQL** : 5.7 ou supérieur (MariaDB 10.3+ compatible)
- **Serveur web** : Apache 2.4+ avec mod_rewrite OU Nginx
- **Git** : (optionnel mais recommandé)

### Navigateur web
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

---

## 💻 Installation locale

### Étape 1 : Télécharger le projet

#### Via Git (recommandé)
```bash
git clone https://github.com/Aminah-0211/gestion_academique.git
cd gestion_academique
```

#### Ou manuellement
- Télécharger le fichier ZIP depuis GitHub
- Extraire dans votre dossier `htdocs` (Apache) ou `html` (autre serveur)
- Renommer le dossier si nécessaire

### Étape 2 : Placer le projet au bon endroit

#### Avec Apache XAMPP
```
C:\xampp\htdocs\gestion_academique\
```

#### Avec Apache WAMP
```
C:\wamp\www\gestion_academique\
```

#### Avec Apache LAMP (Linux)
```
/var/www/html/gestion_academique/
```

#### Avec Nginx
```
/var/www/gestion_academique/
```

---

## ⚙️ Configuration

### Étape 1 : Configuration PHP

#### 1. Éditer `php.ini`

Localiser votre fichier `php.ini` :

**Windows (XAMPP)**
```
C:\xampp\php\php.ini
```

**macOS (Homebrew)**
```
/usr/local/etc/php/7.4/php.ini
ou
/opt/homebrew/etc/php/8.0/php.ini
```

**Linux**
```
/etc/php/8.0/apache2/php.ini
```

#### 2. Paramètres recommandés à modifier

```ini
; Limite de taille pour les uploads (5 MB recommandé)
upload_max_filesize = 5M
post_max_size = 5M

; Délai d'exécution
max_execution_time = 300

; Mémoire
memory_limit = 256M

; Zone horaire
date.timezone = Africa/Dakar
```

#### 3. Extensions PHP nécessaires

Vérifier que les extensions suivantes sont activées dans `php.ini` :
```ini
extension=mysqli
extension=gd
extension=mbstring
extension=json
extension=pdo_mysql
```

**Sur Linux**, installer si manquantes :
```bash
sudo apt-get install php8.0-mysql php8.0-gd php8.0-mbstring
```

**Redémarrer le serveur après modification :**
```bash
# Windows (XAMPP)
xampp-control.exe

# Linux
sudo systemctl restart apache2
```

### Étape 2 : Configuration de la base de données

#### 1. Éditer le fichier de configuration

Ouvrir `config/database.php` et adapter les paramètres :

```php
define('DB_HOST', 'localhost');      // Adresse du serveur MySQL
define('DB_USER', 'root');           // Utilisateur MySQL
define('DB_PASS', '');               // Mot de passe MySQL
define('DB_NAME', 'gestion_academique');  // Nom de la BD
define('DB_PORT', 3306);             // Port MySQL (3306 par défaut)

// URL d'accès à l'application
define('SITE_URL', 'http://localhost/gestion_academique');
```

#### 2. Vérifier la connectivité

```bash
# Linux/macOS
mysql -u root -p -h localhost

# Windows (command line)
mysql -u root -p -h localhost
```

---

## 🗄️ Création de la base de données

### Méthode 1 : Ligne de commande MySQL

```bash
# Se connecter à MySQL
mysql -u root -p

# Créer la base de données
CREATE DATABASE gestion_academique CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Utiliser la base de données
USE gestion_academique;

# Importer le script SQL
source /chemin/vers/sql/schema.sql;
```

### Méthode 2 : phpMyAdmin

1. **Accéder à phpMyAdmin**
   - URL : `http://localhost/phpmyadmin`
   - Utilisateur : `root`
   - Mot de passe : (laisser vide si XAMPP par défaut)

2. **Créer une nouvelle base de données**
   - Cliquer sur "Nouvelle"
   - Nom : `gestion_academique`
   - Interclassement : `utf8mb4_unicode_ci`
   - Cliquer sur "Créer"

3. **Importer le script SQL**
   - Sélectionner la base `gestion_academique`
   - Aller à l'onglet "Importer"
   - Sélectionner le fichier `sql/schema.sql`
   - Cliquer sur "Exécuter"

### Méthode 3 : Outil graphique (MySQL Workbench)

1. Ouvrir MySQL Workbench
2. Se connecter au serveur MySQL
3. File → Open SQL Script → Sélectionner `sql/schema.sql`
4. Exécuter le script

---

## ✅ Vérifications

### Vérifier l'installation PHP

Créer un fichier `test.php` dans le dossier racine :

```php
<?php
phpinfo();
?>
```

Accéder à `http://localhost/gestion_academique/test.php`

Vérifier les informations affichées et supprimer le fichier après.

### Vérifier la connexion MySQL

Créer un fichier `test_db.php` :

```php
<?php
require_once('config/database.php');

if ($conn) {
    echo "Connexion à la base de données réussie!<br>";
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM utilisateurs");
    $row = mysqli_fetch_assoc($result);
    echo "Nombre d'utilisateurs: " . $row['count'];
} else {
    echo "Erreur de connexion!";
}
?>
```

Accéder à `http://localhost/gestion_academique/test_db.php` et supprimer après vérification.

### Vérifier les permissions

```bash
# Sur Linux/macOS
chmod 755 uploads/
chmod 755 documents/
chmod 644 config/database.php

# Vérifier la propriété du dossier
ls -la uploads/
ls -la documents/
```

---

## 🚀 Démarrage de l'application

### 1. Démarrer le serveur web

#### XAMPP (Windows/macOS/Linux)
```bash
# Ouvrir le panneau de contrôle XAMPP
xampp-control.exe          # Windows
./xampp/xampp                # macOS
./xampp-control.sh          # Linux

# Cliquer sur "Start" pour Apache et MySQL
```

#### Apache (Linux)
```bash
sudo systemctl start apache2
sudo systemctl start mysql
```

#### Nginx (Linux)
```bash
sudo systemctl start nginx
sudo systemctl start mysql
```

### 2. Accéder à l'application

Ouvrir votre navigateur et aller à :
```
http://localhost/gestion_academique
```

### 3. Se connecter

Identifiants par défaut :
- **Email** : `admin@suptech.com`
- **Mot de passe** : `Admin@123`

### 4. Changer le mot de passe

1. Se connecter avec les identifiants par défaut
2. Aller à votre profil
3. Changer le mot de passe immédiatement

---

## 🔍 Dépannage

### Erreur : "Impossible de se connecter à la base de données"

**Solutions:**
1. Vérifier que MySQL est démarré
2. Vérifier les paramètres dans `config/database.php`
3. Vérifier les permissions utilisateur MySQL
4. Vérifier le port MySQL (généralement 3306)

```bash
# Tester la connexion
mysql -u root -h localhost
```

### Erreur : "Fichier non trouvé (404)"

**Solutions:**
1. Vérifier le chemin d'accès dans `config/database.php`
2. Vérifier que le projet est dans le bon dossier
3. Vérifier que mod_rewrite est activé (Apache)

```bash
# Activer mod_rewrite sur Apache (Linux)
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Erreur : "Permission refusée pour uploads"

**Solutions:**
```bash
# Donner les permissions
chmod 755 uploads/
chmod 755 documents/
sudo chown -R www-data:www-data uploads/
sudo chown -R www-data:www-data documents/
```

### Erreur : "Délai d'exécution dépassé"

**Solutions:**
1. Éditer `php.ini` et augmenter `max_execution_time`
2. Optimiser les requêtes MySQL
3. Vérifier les logs Apache

```bash
# Voir les logs Apache
tail -f /var/log/apache2/error.log
```

### Erreur : "Classe non trouvée" ou "Fonction non définie"

**Solutions:**
1. Vérifier que tous les fichiers include sont présents
2. Vérifier les chemins relatifs/absolus
3. Vérifier l'encodage des fichiers (UTF-8)

```bash
# Vérifier l'encodage
file -i config/database.php
```

### Problème : Les styles CSS ne s'appliquent pas

**Solutions:**
1. Vérifier le chemin SITE_URL dans `config/database.php`
2. Forcer le rechargement du navigateur (Ctrl+F5)
3. Vider le cache du navigateur
4. Vérifier les permissions des fichiers CSS

---

## 📦 Dépendances optionnelles

### Pour la génération de PDF
```bash
# Installer TCPDF
composer require tecnickcom/tcpdf
```

### Pour l'export Excel
```bash
# Installer PHPExcel
composer require phpoffice/phpexcel
```

### Pour les notifications par email
```bash
# Installer PHPMailer
composer require phpmailer/phpmailer
```

---

## 🔒 Sécurité post-installation

### 1. Changer les mots de passe par défaut
- Admin
- Scolarité (si créé)
- Enseignants

### 2. Configurer HTTPS
- Obtenir un certificat SSL
- Configurer Apache/Nginx pour HTTPS
- Mettre à jour SITE_URL en `https://`

### 3. Sauvegarder les données
```bash
# Sauvegarder la base de données
mysqldump -u root -p gestion_academique > backup.sql

# Sauvegarder les fichiers
tar -czf gestion_academique_backup.tar.gz /chemin/vers/gestion_academique/
```

### 4. Configurer les logs
```bash
# Vérifier les logs erreurs
tail -f /var/log/apache2/error.log
```

---

## ✨ Configuration avancée (optionnelle)

### Activer le cache
Éditer `.htaccess` pour activer le cache des fichiers statiques

### Configurer les sessions
Éditer `config/session.php` pour adapter les paramètres

### Optimiser les images
Redimensionner les images uploadées automatiquement

### Implémenter un CDN
Utiliser un CDN pour les fichiers statiques (CSS, JS, images)

---

## 📞 Support

Pour toute question ou problème :
1. Consulter le README.md
2. Vérifier les fichiers de configuration
3. Consulter les logs (Apache, MySQL)
4. Contacter votre formateur

---

**Formateur** : Mansour Dieng
**Institut** : ENSUP-AFRIQUE
**Année** : 2024-2025
