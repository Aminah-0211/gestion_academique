# CAHIER DES CHARGES
## Gestion Académique - SupTech Business School

**Document de conception - Projet d'examen de fin de semestre**

---

## 1. CONTEXTE DU PROJET

L'Institut "SupTech Business School" souhaite moderniser sa gestion administrative en abandonnant les processus manuels. Un système d'information doit être mis en place pour centraliser la gestion des activités académiques.

### Objectifs
- Centraliser la gestion des informations académiques
- Automatiser les processus de gestion
- Améliorer la collaboration entre les acteurs
- Générer des rapports et statistiques
- Sécuriser les données sensibles

---

## 2. PÉRIMÈTRE FONCTIONNEL

### 2.1 Modules fonctionnels obligatoires

#### 1. **Authentification**
- Connexion sécurisée avec email et mot de passe
- Chiffrage des mots de passe (bcrypt)
- Gestion des rôles et permissions
- Déconnexion avec suppression de session

#### 2. **Tableau de bord**
- Affichage de cartes Bootstrap avec statistiques :
  - Nombre d'étudiants actifs
  - Nombre d'enseignants
  - Nombre de classes
  - Nombre de modules
  - Nombre d'inscriptions
  - Nombre de paiements traités
  - Taux de réussite global
- Affichage des 5 derniers étudiants inscrits
- Affichage des 5 dernières notes enregistrées

#### 3. **Gestion des étudiants**
Opérations CRUD complètes :
- Ajouter étudiant
- Consulter/Lister étudiants
- Modifier les informations
- Supprimer un étudiant
- Upload de photo avec prévisualisation

Données par étudiant :
- Matricule (généré automatiquement)
- Nom et Prénom
- Date de naissance
- Sexe
- Téléphone
- Email
- Adresse
- Photo
- Classe assignée

Fonctionnalités :
- Recherche multicritère (nom, matricule, classe)
- Pagination
- Validation des données
- Gestion du statut (actif, suspendu, gradué)

#### 4. **Gestion des enseignants**
Opérations CRUD :
- Ajouter enseignant
- Lister/Consulter
- Modifier
- Supprimer
- Recherche

Données par enseignant :
- Matricule
- Nom et Prénom
- Grade (Professeur, Maître-Assistant, etc.)
- Téléphone
- Email
- Spécialité

#### 5. **Gestion des classes**
Opérations CRUD :
- Ajouter classe
- Lister/Consulter
- Modifier
- Supprimer

Données par classe :
- Nom de classe
- Filière
- Niveau (L1, L2, L3, etc.)
- Effectif maximum
- Effectif actuel (calculé)

#### 6. **Gestion des modules**
- Créer module avec :
  - Nom et code unique
  - Enseignant responsable
  - Classe(s) associée(s)
  - Coefficient
  - Nombre d'heures
  - Description
- Modifier/Supprimer module
- Lister les modules

#### 7. **Gestion des inscriptions**
- Inscrire un étudiant :
  - Sélectionner l'étudiant
  - Sélectionner la classe
  - Sélectionner l'année universitaire
- Vérifier automatiquement qu'il n'est pas déjà inscrit
- Modifier le statut d'inscription
- Consulter les inscriptions

#### 8. **Gestion des paiements**
- Ajouter un paiement
- Consulter l'historique des paiements
- Enregistrer : montant payé, date, mode de paiement
- Calcul automatique du solde
- Impression du reçu
- Suivi du statut de paiement (en_attente, partiel, payé)

#### 9. **Gestion des notes**
Saisie de notes par enseignant :
- CC (Contrôle Continu)
- TP (Travaux Pratiques)
- Examen

Calcul automatique :
- Moyenne (CC×30% + TP×30% + Examen×40%)
- Mention (Excellent, Très Bien, Bien, Assez Bien, Passable, Ajourné)
- Décision (Validé, Ajourné)
- Classement des étudiants par module

#### 10. **Relevé de notes**
- Génération d'un document affichant :
  - Informations complètes de l'étudiant
  - Toutes les notes par module
  - Moyenne générale
  - Mention globale
  - Décision finale
  - Classement

#### 11. **Emploi du temps**
- Ajouter séance :
  - Jour de la semaine
  - Heure début / Heure fin
  - Salle
  - Classe
  - Enseignant
  - Module
- Modifier/Supprimer/Afficher

Vérification des contraintes :
- Un enseignant ne peut pas être programmé sur deux cours au même horaire
- Une salle ne peut pas être réservée pour deux cours simultanément
- Une classe ne peut pas avoir deux cours au même moment

#### 12. **Statistiques**
Graphiques présentant :
- Répartition des étudiants par classe
- Répartition des étudiants par sexe
- Paiements effectués par mois
- Taux de réussite par classe

### 2.2 Fonctionnalités bonus (optionnelles)
- Génération de documents PDF (relevés, reçus)
- Export des listes en Excel
- Journal des connexions et actions utilisateur
- Notifications en temps réel
- Sauvegarde et restauration de base de données
- Thème clair/sombre

---

## 3. PROFILS UTILISATEURS

### 3.1 Administrateur
- **Accès** : Complet
- **Permissions** :
  - Gestion de tous les modules
  - Gestion des utilisateurs et rôles
  - Consultation des statistiques
  - Gestion du système

### 3.2 Scolarité
- **Accès** : Modules académiques
- **Permissions** :
  - Gestion des étudiants
  - Gestion des classes
  - Gestion des inscriptions
  - Consultation des notes
  - Gestion des paiements

### 3.3 Enseignant
- **Accès** : Modules et notes
- **Permissions** :
  - Saisie des notes (ses modules uniquement)
  - Consultation de son emploi du temps
  - Consultation des étudiants de ses classes
  - Consultation des relevés

---

## 4. EXIGENCES TECHNIQUES

### 4.1 Technologie obligatoires
- **Frontend** :
  - HTML5 (structure sémantique)
  - CSS3 (styles modernes)
  - Bootstrap 5 (responsive design)
  - JavaScript (interactivité)

- **Backend** :
  - PHP 8 (minimum)
  - MySQL (base de données)

### 4.2 Fonctionnalités JavaScript obligatoires
- Validation dynamique des formulaires
- Aperçu des photos avant enregistrement
- Confirmation de suppression
- Recherche instantanée
- Calcul automatique des moyennes
- Calcul automatique du reste à payer
- Notifications interactives
- Menu responsive

### 4.3 Fonctionnalités PHP obligatoires
- Gestion des sessions sécurisées
- Authentification avec vérification
- Upload des fichiers (photos)
- Gestion des erreurs appropriée
- Connexion à MySQL via mysqli
- Fonctions réutilisables
- Pagination des résultats
- Recherche et tri des données

### 4.4 Base de données minimale
Tables obligatoires :
- `utilisateurs` - Comptes utilisateurs
- `roles` - Rôles disponibles
- `enseignants` - Données des enseignants
- `etudiants` - Données des étudiants
- `classes` - Données des classes
- `modules` - Modules de cours
- `inscriptions` - Inscriptions aux classes
- `paiements` - Historique des paiements
- `notes` - Notes des étudiants
- `emploi_temps` - Séances de cours
- `salles` - Salles de cours
- `annees_universitaires` - Années académiques

---

## 5. CONSTRAINTS DE SÉCURITÉ

- Mots de passe chiffrés (bcrypt minimum)
- Protection contre l'injection SQL (prepared statements)
- Protection contre le XSS (HTML encoding)
- Validation des formulaires côté serveur ET client
- Gestion sécurisée des sessions
- Contrôle d'accès basé sur les rôles
- Upload de fichiers sécurisé avec vérification de type
- Limite de taille pour les uploads (5 MB recommandé)
- Journalisation des actions sensibles

---

## 6. CRITÈRES DE RÉUSSITE

### Points d'évaluation (100 points)

| Critère | Points |
|---------|--------|
| Analyse et cahier des charges | 10 |
| Conception de la base de données | 15 |
| Interface Bootstrap | 10 |
| Développement PHP | 25 |
| Exploitation de MySQL | 15 |
| Utilisation de JavaScript | 10 |
| Sécurité et validation | 5 |
| Qualité du code et organisation | 5 |
| Présentation et démonstration | 5 |
| **TOTAL** | **100** |

---

## 7. LIVRABLES ATTENDUS

1. Cahier des charges (ce document)
2. Diagramme de cas d'utilisation (UML)
3. MCD - Modèle Conceptuel de Données (Merise)
4. MLD - Modèle Logique de Données
5. Diagramme relationnel (ER)
6. Script SQL de création de la base de données
7. Maquettes de l'interface (prototypes)
8. Code source complet et commenté
9. Manuel utilisateur

---

## 8. PLANNING ET DÉLAIS

- **Durée du projet** : 1 semestre
- **Format** : Travail en binôme
- **Date de remise** : À définir par l'enseignant
- **Format de livraison** : Archive ZIP `NOM1_NOM2_ProjetExamen.zip`
- **Soutenance** : Après la date de remise

---

## 9. NORMES DE CODAGE

### Structure du projet
- Arborescence clairement organisée
- Séparation logique des responsabilités
- Fichiers de configuration centralisés

### Codage
- Commentaires explicites
- Noms de variables et fonctions explicites
- Indentation cohérente (2 ou 4 espaces)
- Respect des conventions de chaque langage

### Base de données
- Noms de tables au singulier/pluriel cohérents
- Clés primaires et étrangères explicites
- Index appropriés pour les performances

---

## 10. SUPPORT ET DOCUMENTATION

- Code source bien commenté
- README.md complet
- Manuel utilisateur détaillé
- Guides de déploiement

---

**Formateur** : Mansour Dieng
**Institut** : ENSUP-AFRIQUE
**Année** : 2024-2025
