# DÉMARRAGE RAPIDE
## Gestion Académique - SupTech Business School

---

## ⚡ Démarrage en 5 minutes

### 1️⃣ Prérequis
- ✅ PHP 8.0+
- ✅ MySQL/MariaDB
- ✅ Apache/Nginx
- ✅ Navigateur moderne

### 2️⃣ Installation

```bash
# 1. Cloner le projet
git clone https://github.com/Aminah-0211/gestion_academique.git
cd gestion_academique

# 2. Placer dans le dossier web
# Windows XAMPP: C:\xampp\htdocs\gestion_academique\
# Linux: /var/www/html/gestion_academique/
# macOS: ~/Sites/gestion_academique/
```

### 3️⃣ Configuration BD

**Éditer `config/database.php` :**

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestion_academique');
```

### 4️⃣ Créer la base de données

```bash
# Option A : Ligne de commande
mysql -u root -p gestion_academique < sql/schema.sql

# Option B : phpMyAdmin
# 1. Accéder à http://localhost/phpmyadmin
# 2. Créer BD "gestion_academique"
# 3. Importer sql/schema.sql
```

### 5️⃣ Lancer l'application

```bash
# Windows XAMPP
# 1. Ouvrir XAMPP Control Panel
# 2. Cliquer "Start" (Apache + MySQL)

# Linux
sudo systemctl start apache2
sudo systemctl start mysql

# macOS avec Homebrew
brew services start httpd
brew services start mysql
```

### 6️⃣ Accéder à l'application

Ouvrir : **http://localhost/gestion_academique**

### 7️⃣ Se connecter

```
Email    : admin@suptech.com
Password : Admin@123
```

---

## 📁 Structure créée

```
gestion_academique/
├── config/              # Configuration (DB, fonctions, sessions)
├── includes/            # Composants réutilisables
├── assets/              # CSS, JS, images
├── auth/                # Authentification
├── etudiants/           # Gestion des étudiants ✅
├── classes/             # Gestion des classes 🔄
├── modules/             # Gestion des modules 🔄
├── notes/               # Gestion des notes 🔄
├── paiements/           # Gestion des paiements 🔄
├── emplois/             # Emploi du temps 🔄
├── statistiques/        # Statistiques 🔄
├── documents/           # Documentation
├── sql/                 # Scripts BD
├── uploads/             # Fichiers uploadés
├── index.php            # Tableau de bord ✅
├── logout.php           # Déconnexion ✅
└── README.md            # Documentation

Legend: ✅ Complété | 🔄 En cours
```

---

## 🔑 Identifiants par défaut

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Admin | admin@suptech.com | Admin@123 |

⚠️ **Changez ces identifiants après première connexion !**

---

## 📊 Fonctionnalités disponibles

| Fonctionnalité | Statut | Accès |
|---|---|---|
| **Authentification** | ✅ Complète | Tous |
| **Tableau de bord** | ✅ Complète | Tous |
| **Gestion étudiants** | ✅ Complète | Admin, Scolarité |
| **Gestion classes** | 🔄 En cours | Admin, Scolarité |
| **Gestion notes** | 🔄 En cours | Admin, Enseignant |
| **Gestion paiements** | 🔄 En cours | Admin, Scolarité |
| **Emploi du temps** | 🔄 En cours | Admin |
| **Statistiques** | 🔄 En cours | Admin |
| **Relevés de notes** | ⏳ Prévu | Admin, Scolarité |

---

## 🆘 Dépannage rapide

### ❌ "Impossible de se connecter à la BD"
```bash
# Vérifier que MySQL est démarré
mysql -u root -p

# Vérifier config/database.php
cat config/database.php
```

### ❌ "Page blanche"
```bash
# Vérifier les erreurs PHP
tail -f /var/log/apache2/error.log    # Linux
type "error.log" path in XAMPP        # Windows
```

### ❌ "Fichier non trouvé (404)"
```bash
# Vérifier le chemin SITE_URL
# Éditer config/database.php
define('SITE_URL', 'http://localhost/gestion_academique');
```

### ❌ "Permission refusée (uploads)"
```bash
# Linux : Donner permissions
chmod 755 uploads/
chmod 755 documents/

# Ou avec chown
sudo chown -R www-data:www-data uploads/
```

---

## 📚 Documentation

- 📖 **[README.md](README.md)** - Présentation générale
- 📖 **[INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)** - Installation détaillée
- 📖 **[MANUEL_UTILISATEUR.md](documents/MANUEL_UTILISATEUR.md)** - Guide utilisateur
- 📖 **[CAHIER_DES_CHARGES.md](documents/CAHIER_DES_CHARGES.md)** - Cahier des charges
- 📖 **[MCD.md](documents/MCD.md)** - Modèle Conceptuel
- 📖 **[MLD.md](documents/MLD.md)** - Modèle Logique
- 📖 **[PROJECT_STATUS.md](PROJECT_STATUS.md)** - État du projet

---

## 🧪 Test les fonctionnalités

### 1. Ajouter un étudiant
1. Menu → Étudiants → Ajouter
2. Remplir le formulaire
3. Cliquer "Enregistrer"

### 2. Modifier un étudiant
1. Menu → Étudiants → Liste
2. Cliquer sur l'icône ✏️
3. Modifier les données

### 3. Supprimer un étudiant
1. Menu → Étudiants → Liste
2. Cliquer sur l'icône 🗑️
3. Confirmer

### 4. Consulter le tableau de bord
1. Accueil ou Menu → Tableau de Bord
2. Voir les statistiques en direct

---

## 🔒 Sécurité

- ✅ Mots de passe chiffrés (bcrypt)
- ✅ Protection injection SQL
- ✅ Sessions sécurisées
- ✅ Contrôle d'accès par rôles
- ✅ Journal d'audit

⚠️ **À faire après déploiement :**
1. Changer mot de passe admin
2. Activer HTTPS
3. Configurer les logs
4. Faire une sauvegarde

---

## 🚀 Prochaines étapes

1. **Compléter les modules en cours** (classes, notes, paiements)
2. **Ajouter les modules restants** (enseignants, modules, inscriptions)
3. **Implémenter les statistiques**
4. **Générer les relevés de notes**
5. **Tester complètement**
6. **Préparer la soutenance**

---

## 💡 Conseils

- 📌 Consultez la [FAQ](documents/MANUEL_UTILISATEUR.md#foire-aux-questions) pour les questions courantes
- 📌 Lisez le [MANUEL_UTILISATEUR.md](documents/MANUEL_UTILISATEUR.md) en cas de problème
- 📌 Vérifiez les [logs](INSTALLATION_GUIDE.md#dépannage) en cas d'erreur
- 📌 Sauvegardez régulièrement votre base de données

---

## 📞 Support

- 👨‍🏫 Formateur : Mansour Dieng
- 🏫 Institut : ENSUP-AFRIQUE
- 📧 Email : À demander au formateur

---

**Bon développement ! 🎉**

*Version* : 1.0 | *Date* : Juillet 2024 | *Statut* : En développement
