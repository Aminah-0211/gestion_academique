# Gestion Académique - SupTech Business School

## 📋 À propos du projet

Application web complète de gestion académique pour SupTech Business School, permettant de gérer les étudiants, enseignants, classes, modules, notes, paiements et emploi du temps.

**Projet d'examen de fin de semestre**
- Module : Développement Web (HTML5, CSS3, Bootstrap, JavaScript, PHP 8, MySQL)
- Niveau : Licence 3 (L3)
- Format : Travail en binôme

## 🎯 Fonctionnalités principales

### 1. **Authentification sécurisée**
- Connexion avec email et mot de passe chiffré
- Gestion des rôles (Administrateur, Scolarité, Enseignant)
- Gestion des sessions sécurisées
- Déconnexion

### 2. **Tableau de bord**
- Statistiques globales (étudiants, enseignants, classes, modules, inscriptions, paiements)
- Derniers étudiants inscrits
- Dernières notes enregistrées
- Taux de réussite

### 3. **Gestion des étudiants**
- Ajouter, modifier, supprimer, consulter
- Upload de photo
- Recherche multicritère
- Attribution de classe

### 4. **Gestion des enseignants**
- Ajouter, modifier, supprimer, lister
- Recherche
- Assignation de modules

### 5. **Gestion des classes**
- Ajouter, modifier, supprimer, lister
- Gestion de l'effectif

### 6. **Gestion des modules**
- Création et assignation des modules
- Liaison avec enseignant et classe
- Gestion des coefficients

### 7. **Gestion des inscriptions**
- Inscription des étudiants par classe et année universitaire
- Vérification des doublons
- Suivi des statuts

### 8. **Gestion des paiements**
- Enregistrement des paiements
- Historique et calcul du reste à payer
- Génération de reçus
- Impression

### 9. **Gestion des notes**
- Saisie des notes (CC, TP, Examen)
- Calcul automatique de la moyenne
- Génération de mentions et décisions
- Classement des étudiants

### 10. **Relevé de notes**
- Génération de relevés personnalisés
- Affichage complet des informations

### 11. **Emploi du temps**
- Gestion des séances de cours
- Vérification des contraintes (conflits horaires)
- Affichage par classe/enseignant/salle

### 12. **Statistiques**
- Graphiques de répartition
- Taux de réussite
- Paiements effectués

## 🛠️ Technologies utilisées

- **Frontend** : HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend** : PHP 8
- **Base de données** : MySQL
- **Serveur** : Apache/Nginx avec support PHP

## 📁 Structure du projet

```
gestion_academique/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── images/
├── config/
│   ├── database.php
│   ├── functions.php
│   └── session.php
├── includes/
│   ├── header.php
│   ├── sidebar.php
│   └── footer.php
├── auth/
│   ├── login.php
│   └── (autres fichiers d'authentification)
├── dashboard/
│   └── index.php
├── etudiants/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── delete.php
├── enseignants/
├── classes/
├── modules/
├── notes/
├── paiements/
├── emplois/
├── salles/
├── statistiques/
├── sql/
│   └── schema.sql
├── uploads/
├── documents/
├── index.php
├── logout.php
└── README.md
```

## ⚙️ Installation et configuration

### Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Apache avec mod_rewrite activé
- Composer (optionnel)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone https://github.com/Aminah-0211/gestion_academique.git
cd gestion_academique
```

2. **Configurer la base de données**
   - Éditer `config/database.php`
   - Remplacer les paramètres de connexion:
     - `DB_HOST` : localhost (ou votre serveur)
     - `DB_USER` : root (ou votre utilisateur)
     - `DB_PASS` : (votre mot de passe)
     - `DB_NAME` : gestion_academique

3. **Créer la base de données**
   - Importer le script SQL:
   ```bash
   mysql -u root -p < sql/schema.sql
   ```
   - Ou via phpMyAdmin : exécuter le fichier `sql/schema.sql`

4. **Configurer les permissions**
```bash
chmod 755 uploads/
chmod 644 config/database.php
```

5. **Accéder à l'application**
   - URL : http://localhost/gestion_academique
   - Email : admin@suptech.com
   - Mot de passe : Admin@123

## 🔐 Sécurité

- Mots de passe chiffrés avec bcrypt
- Protection contre l'injection SQL (prepared statements)
- Protection XSS (HTML encoding)
- Gestion sécurisée des sessions
- Validation des formulaires côté serveur et client
- Limite de taille pour les uploads
- Journalisation des actions et connexions

## 🎨 Fonctionnalités JavaScript

- ✅ Validation dynamique des formulaires
- ✅ Aperçu des photos avant enregistrement
- ✅ Confirmation de suppression
- ✅ Recherche instantanée
- ✅ Calcul automatique des moyennes
- ✅ Calcul automatique du reste à payer
- ✅ Notifications interactives
- ✅ Menu responsive

## 📊 Fonctionnalités PHP

- ✅ Gestion des sessions sécurisées
- ✅ Authentification et autorisation
- ✅ Upload des fichiers
- ✅ Gestion des erreurs
- ✅ Connexion à la base de données
- ✅ Fonctions réutilisables
- ✅ Pagination
- ✅ Recherche et tri
- ✅ Journal d'audit

## 🎁 Fonctionnalités bonus

- 📄 Génération de documents PDF
- 📊 Export des listes en Excel
- 📋 Journal des connexions et actions
- 🔔 Notifications en temps réel
- 💾 Sauvegarde et restauration de base de données
- 🌓 Thème clair/sombre

## 📚 Livrables du projet

1. ✅ Cahier des charges
2. ✅ Diagramme de cas d'utilisation
3. ✅ MCD (Modèle Conceptuel de Données)
4. ✅ MLD (Modèle Logique de Données)
5. ✅ Diagramme relationnel
6. ✅ Script SQL de création de la base de données
7. ✅ Maquettes de l'interface
8. ✅ Code source complet de l'application
9. ✅ Manuel utilisateur

## 🧪 Tests

### Utilisateurs de test
- **Admin** : admin@suptech.com / Admin@123
- **Scolarité** : scolarite@suptech.com / Scolarite@123
- **Enseignant** : enseignant@suptech.com / Enseignant@123

## 📝 Notes importantes

- Toute modification de la structure de dossiers doit être reflétée dans les chemins des inclusions PHP
- Les fichiers uploads doivent être accessibles en écriture
- Les paramètres de configuration MySQL doivent être adaptés à votre environnement
- La variable `SITE_URL` dans `config/database.php` doit correspondre à votre URL d'accès

## 🤝 Contribution

Ce projet est un travail académique en binôme. Toute ressemblance significative de code entre deux binômes différents entraînera l'annulation de la note.

## 👨‍🏫 Formateur

**Mansour Dieng**
- iOS / Android Dev | Web Dev | Formateur | Sécurité Des Applications | Consultant Stratégie Numérique
- ENSUP-AFRIQUE

## 📄 Licence

Projet académique - ENSUP-AFRIQUE

## 📞 Support

Pour toute question ou problème, veuillez contacter votre formateur.

---

**Date de remise** : À compléter par l'enseignant
**Format de livraison** : Archive ZIP nommée `NOM1_NOM2_ProjetExamen.zip`