# MCD - MODÈLE CONCEPTUEL DE DONNÉES
## Gestion Académique - SupTech Business School

**Modèle Conceptuel de Données (Merise)**

---

## 1. ENTITÉS ET ATTRIBUTS

### 1.1 Entité UTILISATEUR
```
UTILISATEUR
├─ ID_UTILISATEUR (PK)
├─ NOM
├─ PRENOM
├─ EMAIL (UNIQUE)
├─ MOT_DE_PASSE
├─ STATUT (actif, inactif, suspendu)
├─ DATE_CREATION
├─ DATE_MODIFICATION
└─ #ID_ROLE (FK)
```

### 1.2 Entité ROLE
```
ROLE
├─ ID_ROLE (PK)
├─ NOM (UNIQUE)
└─ DESCRIPTION
```

### 1.3 Entité ENSEIGNANT
```
ENSEIGNANT
├─ ID_ENSEIGNANT (PK)
├─ MATRICULE (UNIQUE)
├─ GRADE
├─ TELEPHONE
├─ SPECIALITE
├─ DATE_EMBAUCHE
├─ DATE_CREATION
└─ #ID_UTILISATEUR (FK, UNIQUE)
```

### 1.4 Entité ETUDIANT
```
ETUDIANT
├─ ID_ETUDIANT (PK)
├─ MATRICULE (UNIQUE)
├─ NOM
├─ PRENOM
├─ DATE_NAISSANCE
├─ SEXE (M, F)
├─ TELEPHONE
├─ EMAIL
├─ ADRESSE
├─ PHOTO
├─ STATUT (actif, suspendu, gradué)
├─ DATE_INSCRIPTION
└─ #ID_CLASSE (FK)
```

### 1.5 Entité CLASSE
```
CLASSE
├─ ID_CLASSE (PK)
├─ NOM
├─ FILIERE
├─ NIVEAU
├─ EFFECTIF_MAX
├─ EFFECTIF_ACTUEL
└─ DATE_CREATION
```

### 1.6 Entité MODULE
```
MODULE
├─ ID_MODULE (PK)
├─ NOM
├─ CODE (UNIQUE)
├─ COEFFICIENT
├─ NOMBRE_HEURES
├─ DESCRIPTION
├─ DATE_CREATION
├─ #ID_ENSEIGNANT (FK)
└─ #ID_CLASSE (FK)
```

### 1.7 Entité INSCRIPTION
```
INSCRIPTION
├─ ID_INSCRIPTION (PK)
├─ STATUT (en_cours, completee, abandonnee)
├─ DATE_INSCRIPTION
├─ #ID_ETUDIANT (FK)
├─ #ID_CLASSE (FK)
└─ #ID_ANNEE_UNIV (FK)
```

### 1.8 Entité NOTE
```
NOTE
├─ ID_NOTE (PK)
├─ CC (CONTROLE_CONTINU)
├─ TP (TRAVAUX_PRATIQUES)
├─ EXAMEN
├─ MOYENNE (calculée)
├─ MENTION
├─ DECISION
├─ DATE_ENREGISTREMENT
├─ DATE_MODIFICATION
├─ #ID_ETUDIANT (FK)
└─ #ID_MODULE (FK)
```

### 1.9 Entité PAIEMENT
```
PAIEMENT
├─ ID_PAIEMENT (PK)
├─ MONTANT_TOTAL
├─ MONTANT_PAYE
├─ RESTE_A_PAYER
├─ DATE_PAIEMENT
├─ MODE_PAIEMENT
├─ REFERENCE
├─ STATUT (en_attente, partiel, paye)
├─ DATE_CREATION
├─ DATE_MODIFICATION
└─ #ID_ETUDIANT (FK)
```

### 1.10 Entité SALLE
```
SALLE
├─ ID_SALLE (PK)
├─ NUMERO (UNIQUE)
├─ CAPACITE
├─ TYPE_SALLE
├─ BATIMENT
├─ EQUIPEMENTS
└─ DATE_CREATION
```

### 1.11 Entité EMPLOI_TEMPS
```
EMPLOI_TEMPS
├─ ID_SEANCE (PK)
├─ JOUR
├─ HEURE_DEBUT
├─ HEURE_FIN
├─ DATE_CREATION
├─ #ID_SALLE (FK)
├─ #ID_CLASSE (FK)
├─ #ID_ENSEIGNANT (FK)
├─ #ID_MODULE (FK)
└─ #ID_ANNEE_UNIV (FK)
```

### 1.12 Entité ANNEE_UNIVERSITAIRE
```
ANNEE_UNIVERSITAIRE
├─ ID_ANNEE (PK)
├─ ANNEE (UNIQUE)
├─ DATE_DEBUT
├─ DATE_FIN
├─ ACTUELLE (BOOLEAN)
└─ DATE_CREATION
```

### 1.13 Entité RELEVE_NOTES
```
RELEVE_NOTES
├─ ID_RELEVE (PK)
├─ MOYENNE_GENERALE
├─ NOMBRE_MODULES_REUSSIS
├─ NOMBRE_MODULES_TOTAL
├─ TAUX_REUSSITE
├─ DECISION_FINALE
├─ DATE_GENERATION
├─ #ID_ETUDIANT (FK)
└─ #ID_ANNEE_UNIV (FK)
```

### 1.14 Entité JOURNAL_ACTIONS
```
JOURNAL_ACTIONS
├─ ID_ACTION (PK)
├─ ACTION
├─ DETAILS
├─ ADRESSE_IP
├─ TIMESTAMP
└─ #ID_UTILISATEUR (FK)
```

### 1.15 Entité JOURNAL_CONNEXIONS
```
JOURNAL_CONNEXIONS
├─ ID_CONNEXION (PK)
├─ DATE_CONNEXION
├─ DATE_DECONNEXION
├─ ADRESSE_IP
├─ NAVIGATEUR
└─ #ID_UTILISATEUR (FK)
```

---

## 2. ASSOCIATIONS ET CARDINALITÉS

### 2.1 Diagramme des relations

```
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│  ROLE (1,1) ────── (0,N) UTILISATEUR ────── (1,1) ETUDIANT  │
│                                        │                    │
│                                        └────── (1,1) ENSEIGNANT
│                                                             │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                                                             │
│  CLASSE (1,1) ────── (1,N) ETUDIANT (0,N) ─────── INSCRIPTION
│    │                                                        │
│    └─────────────────────────── (1,1)                      │
│                                                             │
│  CLASSE (0,N) ────── MODULE (1,1) ────── ENSEIGNANT        │
│                         │                                   │
│                         └────── (1,N) NOTE (N,1) ETUDIANT  │
│                                                             │
│  ANNEE_UNIVERSITAIRE (0,N) ────── INSCRIPTION              │
│  ANNEE_UNIVERSITAIRE (0,N) ────── EMPLOI_TEMPS             │
│  ANNEE_UNIVERSITAIRE (0,N) ────── RELEVE_NOTES             │
│                                                             │
│  ETUDIANT (1,N) ────── PAIEMENT                            │
│  ETUDIANT (1,N) ────── RELEVE_NOTES                        │
│  ETUDIANT (1,N) ────── JOURNAL_CONNEXIONS                  │
│                                                             │
│  EMPLOI_TEMPS (N,1) ────── SALLE                           │
│  EMPLOI_TEMPS (N,1) ────── CLASSE                          │
│  EMPLOI_TEMPS (N,1) ────── ENSEIGNANT                      │
│  EMPLOI_TEMPS (N,1) ────── MODULE                          │
│                                                             │
│  UTILISATEUR (1,N) ────── JOURNAL_ACTIONS                  │
│  UTILISATEUR (1,N) ────── JOURNAL_CONNEXIONS               │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## 3. ASSOCIATIONS DÉTAILLÉES

### Association APPARTENIR
```
UTILISATEUR (1,1) ──── APPARTENIR ──── (0,N) ROLE

Cardinalités :
- Un utilisateur appartient à exactement 1 rôle
- Un rôle peut être possédé par plusieurs utilisateurs (0 à plusieurs)
```

### Association INSCRIRE
```
ETUDIANT (N,1) ──── INSCRIRE ──── (1,N) CLASSE
ETUDIANT (N,1) ──── INSCRIRE ──── (1,N) ANNEE_UNIVERSITAIRE

Attributs de l'association :
- DATE_INSCRIPTION
- STATUT
```

### Association ENSEIGNER
```
ENSEIGNANT (1,1) ──── ENSEIGNER ──── (1,N) MODULE
MODULE (N,1) ──── ENSEIGNER ──── (1,1) CLASSE
```

### Association EVALUER
```
ETUDIANT (N,1) ──── EVALUER ──── (1,N) MODULE

Attributs de l'association :
- CC (Contrôle Continu)
- TP (Travaux Pratiques)
- EXAMEN
- MOYENNE (calculée)
- MENTION
- DECISION
```

### Association PLANIFIER
```
CLASSE (1,N) ──── PLANIFIER ──── (0,N) EMPLOI_TEMPS
ENSEIGNANT (1,N) ──── PLANIFIER ──── (0,N) EMPLOI_TEMPS
MODULE (1,N) ──── PLANIFIER ──── (0,N) EMPLOI_TEMPS
SALLE (1,N) ──── PLANIFIER ──── (0,N) EMPLOI_TEMPS

Attributs de l'association :
- JOUR
- HEURE_DEBUT
- HEURE_FIN
- DATE_CREATION
```

---

## 4. CONTRAINTES D'INTÉGRITÉ

### Contraintes de domaine
- **SEXE** ∈ {M, F}
- **STATUT** (Utilisateur) ∈ {actif, inactif, suspendu}
- **STATUT** (Étudiant) ∈ {actif, suspendu, gradué}
- **STATUT** (Inscription) ∈ {en_cours, completee, abandonnee}
- **STATUT** (Paiement) ∈ {en_attente, partiel, paye}
- **MENTION** ∈ {Excellent, Très Bien, Bien, Assez Bien, Passable, Ajourné}
- **DECISION** ∈ {Validé, Ajourné}
- **JOUR** ∈ {Lundi, Mardi, Mercredi, Jeudi, Vendredi, Samedi, Dimanche}

### Contraintes d'unicité
- EMAIL (Utilisateur) - UNIQUE
- MATRICULE (Étudiant) - UNIQUE
- MATRICULE (Enseignant) - UNIQUE
- CODE (Module) - UNIQUE
- NUMERO (Salle) - UNIQUE
- NOM + FILIERE + NIVEAU (Classe) - UNIQUE
- ANNEE (Année Universitaire) - UNIQUE
- ETUDIANT_ID + MODULE_ID (Note) - UNIQUE
- ETUDIANT_ID + CLASSE_ID + ANNEE_ID (Inscription) - UNIQUE
- ETUDIANT_ID + ANNEE_ID (Relevé de Notes) - UNIQUE

### Contraintes de domaine numérique
- EFFECTIF_MAX ≥ 0
- EFFECTIF_ACTUEL ≥ 0 et ≤ EFFECTIF_MAX
- COEFFICIENT ≥ 1
- NOMBRE_HEURES ≥ 0
- CAPACITE ≥ 0
- CC ∈ [0, 20]
- TP ∈ [0, 20]
- EXAMEN ∈ [0, 20]
- MOYENNE ∈ [0, 20]
- TAUX_REUSSITE ∈ [0, 100]

---

## 5. RÈGLES DE GESTION

### R1 : Attribution de classe à un étudiant
- Un étudiant ne peut avoir qu'une seule classe à un moment donné
- Un étudiant ne peut pas s'inscrire deux fois à la même classe pour une même année

### R2 : Effectif des classes
- L'effectif actuel d'une classe doit être ≤ à l'effectif maximum
- L'effectif actuel se met à jour automatiquement

### R3 : Inscription aux modules
- Un étudiant inscrit à une classe suit tous les modules de cette classe
- Lors de la saisie de notes, l'étudiant doit être inscrit à la classe du module

### R4 : Calcul des notes
- La moyenne est calculée : CC×30% + TP×30% + Examen×40%
- La mention est basée sur la moyenne
- La décision (Validé/Ajourné) est basée sur la moyenne (≥10 = Validé)

### R5 : Emploi du temps
- Pas de conflit d'enseignant (un enseignant ne peut pas être sur 2 cours au même moment)
- Pas de conflit de salle (une salle ne peut pas accueillir 2 cours simultanément)
- Pas de conflit de classe (une classe ne peut pas avoir 2 cours au même moment)

### R6 : Paiements
- Un étudiant peut avoir plusieurs paiements
- Le reste à payer = montant_total - montant_paye
- Le statut du paiement dépend de la progression (en_attente, partiel, paye)

### R7 : Rôles et permissions
- Administrateur : accès complet
- Scolarité : gestion des étudiants, classes, inscriptions, paiements
- Enseignant : saisie des notes de ses modules uniquement

---

## 6. DÉPENDANCES FONCTIONNELLES

```
UTILISATEUR:
  ID_UTILISATEUR → NOM, PRENOM, EMAIL, MOT_DE_PASSE, STATUT, DATE_CREATION, DATE_MODIFICATION, ID_ROLE

ETUDIANT:
  ID_ETUDIANT → MATRICULE, NOM, PRENOM, DATE_NAISSANCE, SEXE, TELEPHONE, EMAIL, ADRESSE, PHOTO, STATUT, DATE_INSCRIPTION, ID_CLASSE

NOTE:
  ID_ETUDIANT, ID_MODULE → CC, TP, EXAMEN, MOYENNE, MENTION, DECISION, DATE_ENREGISTREMENT

MODULE:
  ID_MODULE → NOM, CODE, COEFFICIENT, NOMBRE_HEURES, DESCRIPTION, ID_ENSEIGNANT, ID_CLASSE
```

---

## 7. SCHÉMA RELATIONNEL SIMPLIFIÉ

```
Utilisateurs (ID, Nom, Prénom, Email, Mot de passe, Rôle)
    ↓
Rôles (ID, Nom, Description)

Classes (ID, Nom, Filière, Niveau, Effectif Max)
    ↓
Étudiants (ID, Matricule, Nom, Prénom, DOB, Sexe, Téléphone, Email, Adresse, Photo, Classe)
    ↓
Inscriptions (ID, Étudiant, Classe, Année, Date, Statut)
    ↓
Modules (ID, Nom, Code, Coefficient, Heures, Enseignant, Classe)
    ↓
Notes (ID, Étudiant, Module, CC, TP, Examen, Moyenne, Mention, Décision)

Enseignants (ID, Matricule, Grade, Téléphone, Spécialité, Utilisateur)

Salles (ID, Numéro, Capacité, Type, Bâtiment)

Emploi du temps (ID, Jour, Heure début, Heure fin, Salle, Classe, Enseignant, Module)

Paiements (ID, Étudiant, Montant total, Montant payé, Reste à payer, Date, Mode, Statut)

Années universitaires (ID, Année, Date début, Date fin, Actuelle)

Relevés de notes (ID, Étudiant, Année, Moyenne générale, Modules réussis, Taux réussite)

Journal des actions (ID, Utilisateur, Action, Détails, IP, Timestamp)

Journal des connexions (ID, Utilisateur, Date connexion, Date déconnexion, IP, Navigateur)
```

---

**Formateur** : Mansour Dieng
**Institut** : ENSUP-AFRIQUE
**Année** : 2024-2025
