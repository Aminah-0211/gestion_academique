# MLD - MODÈLE LOGIQUE DE DONNÉES
## Gestion Académique - SupTech Business School

**Modèle Logique de Données (Transformation du MCD)**

---

## 1. DÉFINITION DU MLD

Le Modèle Logique de Données (MLD) est la transformation du MCD en respectant les règles de normalisation relationnelle. Il prépare le passage à la base de données physique.

---

## 2. RELATIONS ET ATTRIBUTS

### 2.1 Relation ROLE
```
ROLE (#ID_ROLE, NOM, DESCRIPTION)
```
- **Clé primaire** : ID_ROLE
- **Contraintes** :
  - NOM UNIQUE NOT NULL
  - Domaine de NOM : {Administrateur, Scolarité, Enseignant}

---

### 2.2 Relation UTILISATEUR
```
UTILISATEUR (#ID_UTILISATEUR, NOM, PRENOM, EMAIL, MOT_DE_PASSE, STATUT, DATE_CREATION, DATE_MODIFICATION, *ID_ROLE)
```
- **Clé primaire** : ID_UTILISATEUR
- **Clé étrangère** : ID_ROLE → ROLE(ID_ROLE)
- **Contraintes** :
  - EMAIL UNIQUE NOT NULL
  - MOT_DE_PASSE NOT NULL
  - STATUT DEFAULT 'actif'
  - STATUT ∈ {actif, inactif, suspendu}
  - DATE_CREATION DEFAULT CURRENT_TIMESTAMP
  - DATE_MODIFICATION AUTO UPDATE CURRENT_TIMESTAMP

---

### 2.3 Relation ENSEIGNANT
```
ENSEIGNANT (#ID_ENSEIGNANT, MATRICULE, GRADE, TELEPHONE, SPECIALITE, DATE_EMBAUCHE, DATE_CREATION, *ID_UTILISATEUR)
```
- **Clé primaire** : ID_ENSEIGNANT
- **Clé étrangère** : ID_UTILISATEUR → UTILISATEUR(ID_UTILISATEUR) UNIQUE
- **Contraintes** :
  - MATRICULE UNIQUE NOT NULL
  - Le lien avec UTILISATEUR doit être unique (un utilisateur = un enseignant)

---

### 2.4 Relation ANNEE_UNIVERSITAIRE
```
ANNEE_UNIVERSITAIRE (#ID_ANNEE_UNIV, ANNEE, DATE_DEBUT, DATE_FIN, ACTUELLE, DATE_CREATION)
```
- **Clé primaire** : ID_ANNEE_UNIV
- **Contraintes** :
  - ANNEE UNIQUE NOT NULL
  - DATE_DEBUT < DATE_FIN
  - ACTUELLE BOOLEAN DEFAULT FALSE
  - Une seule année universitaire peut avoir ACTUELLE = TRUE

---

### 2.5 Relation CLASSE
```
CLASSE (#ID_CLASSE, NOM, FILIERE, NIVEAU, EFFECTIF_MAX, EFFECTIF_ACTUEL, DATE_CREATION)
```
- **Clé primaire** : ID_CLASSE
- **Contraintes** :
  - (NOM, FILIERE, NIVEAU) UNIQUE
  - EFFECTIF_MAX > 0
  - EFFECTIF_ACTUEL DEFAULT 0
  - EFFECTIF_ACTUEL ≤ EFFECTIF_MAX

---

### 2.6 Relation ETUDIANT
```
ETUDIANT (#ID_ETUDIANT, MATRICULE, NOM, PRENOM, DATE_NAISSANCE, SEXE, TELEPHONE, EMAIL, ADRESSE, PHOTO, DATE_INSCRIPTION, STATUT, *ID_CLASSE)
```
- **Clé primaire** : ID_ETUDIANT
- **Clé étrangère** : ID_CLASSE → CLASSE(ID_CLASSE)
- **Contraintes** :
  - MATRICULE UNIQUE NOT NULL
  - SEXE ∈ {M, F}
  - STATUT DEFAULT 'actif'
  - STATUT ∈ {actif, suspendu, gradué}
  - DATE_INSCRIPTION DEFAULT CURRENT_TIMESTAMP
  - DATE_NAISSANCE < DATE_INSCRIPTION

---

### 2.7 Relation INSCRIPTION
```
INSCRIPTION (#ID_INSCRIPTION, DATE_INSCRIPTION, STATUT, *ID_ETUDIANT, *ID_CLASSE, *ID_ANNEE_UNIV)
```
- **Clé primaire** : ID_INSCRIPTION
- **Clés étrangères** :
  - ID_ETUDIANT → ETUDIANT(ID_ETUDIANT)
  - ID_CLASSE → CLASSE(ID_CLASSE)
  - ID_ANNEE_UNIV → ANNEE_UNIVERSITAIRE(ID_ANNEE_UNIV)
- **Clé candidate** : (ID_ETUDIANT, ID_CLASSE, ID_ANNEE_UNIV) UNIQUE
- **Contraintes** :
  - STATUT DEFAULT 'en_cours'
  - STATUT ∈ {en_cours, completee, abandonnee}
  - DATE_INSCRIPTION DEFAULT CURRENT_TIMESTAMP

---

### 2.8 Relation MODULE
```
MODULE (#ID_MODULE, NOM, CODE, COEFFICIENT, NOMBRE_HEURES, DESCRIPTION, DATE_CREATION, *ID_ENSEIGNANT, *ID_CLASSE)
```
- **Clé primaire** : ID_MODULE
- **Clés étrangères** :
  - ID_ENSEIGNANT → ENSEIGNANT(ID_ENSEIGNANT)
  - ID_CLASSE → CLASSE(ID_CLASSE)
- **Contraintes** :
  - CODE UNIQUE NOT NULL
  - NOM NOT NULL
  - COEFFICIENT ≥ 1
  - NOMBRE_HEURES ≥ 0

---

### 2.9 Relation NOTE
```
NOTE (#ID_NOTE, CC, TP, EXAMEN, MOYENNE, MENTION, DECISION, DATE_ENREGISTREMENT, DATE_MODIFICATION, *ID_ETUDIANT, *ID_MODULE)
```
- **Clé primaire** : ID_NOTE
- **Clés étrangères** :
  - ID_ETUDIANT → ETUDIANT(ID_ETUDIANT)
  - ID_MODULE → MODULE(ID_MODULE)
- **Clé candidate** : (ID_ETUDIANT, ID_MODULE) UNIQUE
- **Contraintes** :
  - CC ∈ [0, 20]
  - TP ∈ [0, 20]
  - EXAMEN ∈ [0, 20]
  - MOYENNE = CC × 0.3 + TP × 0.3 + EXAMEN × 0.4
  - MENTION calculée depuis MOYENNE
  - DECISION ∈ {Validé, Ajourné}
  - DATE_ENREGISTREMENT DEFAULT CURRENT_TIMESTAMP
  - DATE_MODIFICATION AUTO UPDATE CURRENT_TIMESTAMP

---

### 2.10 Relation SALLE
```
SALLE (#ID_SALLE, NUMERO, CAPACITE, TYPE_SALLE, BATIMENT, EQUIPEMENTS, DATE_CREATION)
```
- **Clé primaire** : ID_SALLE
- **Contraintes** :
  - NUMERO UNIQUE NOT NULL
  - CAPACITE > 0

---

### 2.11 Relation EMPLOI_TEMPS
```
EMPLOI_TEMPS (#ID_SEANCE, JOUR, HEURE_DEBUT, HEURE_FIN, DATE_CREATION, *ID_SALLE, *ID_CLASSE, *ID_ENSEIGNANT, *ID_MODULE, *ID_ANNEE_UNIV)
```
- **Clé primaire** : ID_SEANCE
- **Clés étrangères** :
  - ID_SALLE → SALLE(ID_SALLE)
  - ID_CLASSE → CLASSE(ID_CLASSE)
  - ID_ENSEIGNANT → ENSEIGNANT(ID_ENSEIGNANT)
  - ID_MODULE → MODULE(ID_MODULE)
  - ID_ANNEE_UNIV → ANNEE_UNIVERSITAIRE(ID_ANNEE_UNIV)
- **Contraintes** :
  - JOUR ∈ {Lundi, Mardi, Mercredi, Jeudi, Vendredi, Samedi, Dimanche}
  - HEURE_DEBUT < HEURE_FIN
  - Pas de conflit enseignant : Contrainte applicative
  - Pas de conflit salle : Contrainte applicative
  - Pas de conflit classe : Contrainte applicative

---

### 2.12 Relation PAIEMENT
```
PAIEMENT (#ID_PAIEMENT, MONTANT_TOTAL, MONTANT_PAYE, RESTE_A_PAYER, DATE_PAIEMENT, MODE_PAIEMENT, REFERENCE, STATUT, DATE_CREATION, DATE_MODIFICATION, *ID_ETUDIANT)
```
- **Clé primaire** : ID_PAIEMENT
- **Clé étrangère** : ID_ETUDIANT → ETUDIANT(ID_ETUDIANT)
- **Contraintes** :
  - MONTANT_TOTAL > 0
  - MONTANT_PAYE DEFAULT 0
  - RESTE_A_PAYER = MONTANT_TOTAL - MONTANT_PAYE
  - STATUT DEFAULT 'en_attente'
  - STATUT ∈ {en_attente, partiel, paye}
  - DATE_PAIEMENT ≤ CURRENT_DATE
  - DATE_MODIFICATION AUTO UPDATE CURRENT_TIMESTAMP

---

### 2.13 Relation RELEVE_NOTES
```
RELEVE_NOTES (#ID_RELEVE, MOYENNE_GENERALE, NOMBRE_MODULES_REUSSIS, NOMBRE_MODULES_TOTAL, TAUX_REUSSITE, DECISION_FINALE, DATE_GENERATION, *ID_ETUDIANT, *ID_ANNEE_UNIV)
```
- **Clé primaire** : ID_RELEVE
- **Clés étrangères** :
  - ID_ETUDIANT → ETUDIANT(ID_ETUDIANT)
  - ID_ANNEE_UNIV → ANNEE_UNIVERSITAIRE(ID_ANNEE_UNIV)
- **Clé candidate** : (ID_ETUDIANT, ID_ANNEE_UNIV) UNIQUE
- **Contraintes** :
  - MOYENNE_GENERALE ∈ [0, 20]
  - NOMBRE_MODULES_REUSSIS ≤ NOMBRE_MODULES_TOTAL
  - TAUX_REUSSITE = (NOMBRE_MODULES_REUSSIS / NOMBRE_MODULES_TOTAL) × 100
  - DECISION_FINALE calculée
  - DATE_GENERATION DEFAULT CURRENT_TIMESTAMP

---

### 2.14 Relation JOURNAL_ACTIONS
```
JOURNAL_ACTIONS (#ID_ACTION, ACTION, DETAILS, ADRESSE_IP, TIMESTAMP, *ID_UTILISATEUR)
```
- **Clé primaire** : ID_ACTION
- **Clé étrangère** : ID_UTILISATEUR → UTILISATEUR(ID_UTILISATEUR) [peut être NULL]
- **Contraintes** :
  - TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  - ACTION NOT NULL

---

### 2.15 Relation JOURNAL_CONNEXIONS
```
JOURNAL_CONNEXIONS (#ID_CONNEXION, DATE_CONNEXION, DATE_DECONNEXION, ADRESSE_IP, NAVIGATEUR, *ID_UTILISATEUR)
```
- **Clé primaire** : ID_CONNEXION
- **Clé étrangère** : ID_UTILISATEUR → UTILISATEUR(ID_UTILISATEUR) [peut être NULL]
- **Contraintes** :
  - DATE_CONNEXION DEFAULT CURRENT_TIMESTAMP
  - DATE_DECONNEXION ≥ DATE_CONNEXION (si NOT NULL)

---

## 3. NORMALISATION

### Formes normales

**1ère Forme Normale (1NF)**
- ✅ Tous les attributs sont atomiques
- ✅ Pas d'attributs multivalués
- ✅ Pas de groupes répétitifs

**2ème Forme Normale (2NF)**
- ✅ 1NF respectée
- ✅ Tous les attributs non-clés dépendent de la clé primaire
- ✅ Pas de dépendances partielles

**3ème Forme Normale (3NF)**
- ✅ 2NF respectée
- ✅ Pas de dépendances transitives
- ✅ Pas d'attributs non-clés dépendant d'autres attributs non-clés

**Forme Normale de Boyce-Codd (BCNF)**
- ✅ Tous les déterminants sont des clés candidates

---

## 4. CALCULS ET ATTRIBUTS DÉRIVÉS

### Attributs calculés

#### ETUDIANT.DATE_NAISSANCE
- Source : Table ETUDIANT
- Calcul : None (données saisies)

#### NOTE.MOYENNE
```
MOYENNE = CC × 0.30 + TP × 0.30 + EXAMEN × 0.40
```
- Calculée lors de l'enregistrement
- Stockée pour optimiser les requêtes

#### NOTE.MENTION
```
SI MOYENNE >= 18 ALORS "Excellent"
SINON SI MOYENNE >= 16 ALORS "Très Bien"
SINON SI MOYENNE >= 14 ALORS "Bien"
SINON SI MOYENNE >= 12 ALORS "Assez Bien"
SINON SI MOYENNE >= 10 ALORS "Passable"
SINON "Ajourné"
```

#### NOTE.DECISION
```
SI MOYENNE >= 10 ALORS "Validé"
SINON "Ajourné"
```

#### CLASSE.EFFECTIF_ACTUEL
```
EFFECTIF_ACTUEL = COUNT(ETUDIANT) WHERE CLASSE.ID = ETUDIANT.ID_CLASSE AND ETUDIANT.STATUT = 'actif'
```
- Mis à jour lors de chaque inscription/suppression

#### PAIEMENT.RESTE_A_PAYER
```
RESTE_A_PAYER = MONTANT_TOTAL - MONTANT_PAYE
```

#### PAIEMENT.STATUT
```
SI MONTANT_PAYE = 0 ALORS "en_attente"
SINON SI MONTANT_PAYE < MONTANT_TOTAL ALORS "partiel"
SINON "paye"
```

#### RELEVE_NOTES.MOYENNE_GENERALE
```
MOYENNE_GENERALE = AVG(NOTE.MOYENNE) 
WHERE ETUDIANT_ID = ? AND MODULE.ID_CLASSE = ETUDIANT.ID_CLASSE
```

#### RELEVE_NOTES.TAUX_REUSSITE
```
TAUX_REUSSITE = (NOMBRE_MODULES_REUSSIS / NOMBRE_MODULES_TOTAL) × 100
```

---

## 5. INDEX RECOMMANDÉS

```
-- Clés primaires
PRIMARY KEY (ID_UTILISATEUR)
PRIMARY KEY (ID_ROLE)
PRIMARY KEY (ID_ENSEIGNANT)
PRIMARY KEY (ID_ETUDIANT)
PRIMARY KEY (ID_CLASSE)
PRIMARY KEY (ID_MODULE)
PRIMARY KEY (ID_NOTE)
PRIMARY KEY (ID_PAIEMENT)
PRIMARY KEY (ID_SALLE)
PRIMARY KEY (ID_EMPLOI_TEMPS)
PRIMARY KEY (ID_INSCRIPTION)
PRIMARY KEY (ID_RELEVE_NOTES)

-- Index sur les clés étrangères
INDEX idx_utilisateur_role (ID_ROLE)
INDEX idx_etudiant_classe (ID_CLASSE)
INDEX idx_module_enseignant (ID_ENSEIGNANT)
INDEX idx_module_classe (ID_CLASSE)
INDEX idx_note_etudiant (ID_ETUDIANT)
INDEX idx_note_module (ID_MODULE)
INDEX idx_paiement_etudiant (ID_ETUDIANT)
INDEX idx_inscription_etudiant (ID_ETUDIANT)
INDEX idx_inscription_classe (ID_CLASSE)
INDEX idx_inscription_annee (ID_ANNEE_UNIV)
INDEX idx_emploi_temps_classe (ID_CLASSE)
INDEX idx_emploi_temps_jour (JOUR)

-- Index sur les colonnes d'authentification et recherche
INDEX idx_utilisateur_email (EMAIL)
INDEX idx_etudiant_matricule (MATRICULE)
INDEX idx_enseignant_matricule (MATRICULE)
INDEX idx_module_code (CODE)
INDEX idx_salle_numero (NUMERO)

-- Index composites pour les requêtes fréquentes
INDEX idx_note_etudiant_module (ID_ETUDIANT, ID_MODULE)
INDEX idx_inscription_unique (ID_ETUDIANT, ID_CLASSE, ID_ANNEE_UNIV)
```

---

## 6. VUE D'ENSEMBLE DU FLUX DE DONNÉES

```
Connexion
    ↓
UTILISATEUR (authentification)
    ↓
[Administrateur] → Tous les modules
[Scolarité] → Étudiants, Classes, Inscriptions, Paiements
[Enseignant] → Notes (ses modules)
    ↓
CLASSE → ETUDIANT → INSCRIPTION → MODULES → NOTES
    ↓
EMPLOI_TEMPS (SALLE, ENSEIGNANT, MODULE, CLASSE)
    ↓
PAIEMENT (suivi financier)
    ↓
RELEVE_NOTES (synthèse académique)
    ↓
JOURNAL_ACTIONS (audit et traçabilité)
```

---

**Formateur** : Mansour Dieng
**Institut** : ENSUP-AFRIQUE
**Année** : 2024-2025
