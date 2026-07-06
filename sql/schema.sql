-- =====================================================
-- SCRIPT DE CRÉATION DE LA BASE DE DONNÉES
-- Gestion Académique - SupTech Business School
-- =====================================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS gestion_academique;
USE gestion_academique;

-- =====================================================
-- TABLE RÔLES
-- =====================================================
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insérer les rôles
INSERT INTO roles (nom, description) VALUES
('Administrateur', 'Accès complet à l\'application'),
('Scolarité', 'Gestion des étudiants et inscriptions'),
('Enseignant', 'Gestion des notes de ses modules');

-- =====================================================
-- TABLE UTILISATEURS
-- =====================================================
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    statut ENUM('actif', 'inactif', 'suspendu') DEFAULT 'actif',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    INDEX idx_email (email),
    INDEX idx_role (role_id)
);

-- =====================================================
-- TABLE ANNEES UNIVERSITAIRES
-- =====================================================
CREATE TABLE annees_universitaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    annee VARCHAR(20) NOT NULL UNIQUE,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    actuelle BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- TABLE CLASSES
-- =====================================================
CREATE TABLE classes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    filiere VARCHAR(100) NOT NULL,
    niveau VARCHAR(50) NOT NULL,
    effectif_max INT NOT NULL,
    effectif_actuel INT DEFAULT 0,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_classe (nom, filiere, niveau)
);

-- =====================================================
-- TABLE ENSEIGNANTS
-- =====================================================
CREATE TABLE enseignants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL UNIQUE,
    matricule VARCHAR(50) NOT NULL UNIQUE,
    grade VARCHAR(100),
    specialite VARCHAR(200),
    telephone VARCHAR(20),
    date_embauche DATE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- =====================================================
-- TABLE ÉTUDIANTS
-- =====================================================
CREATE TABLE etudiants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matricule VARCHAR(50) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    sexe ENUM('M', 'F') NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(100),
    adresse TEXT,
    photo VARCHAR(255),
    classe_id INT NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('actif', 'suspendu', 'gradué') DEFAULT 'actif',
    FOREIGN KEY (classe_id) REFERENCES classes(id),
    INDEX idx_matricule (matricule),
    INDEX idx_classe (classe_id)
);

-- =====================================================
-- TABLE MODULES
-- =====================================================
CREATE TABLE modules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(150) NOT NULL,
    code VARCHAR(50) NOT NULL UNIQUE,
    enseignant_id INT NOT NULL,
    classe_id INT NOT NULL,
    coefficient INT NOT NULL DEFAULT 1,
    nombre_heures INT NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (enseignant_id) REFERENCES enseignants(id),
    FOREIGN KEY (classe_id) REFERENCES classes(id),
    INDEX idx_classe (classe_id)
);

-- =====================================================
-- TABLE INSCRIPTIONS
-- =====================================================
CREATE TABLE inscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    etudiant_id INT NOT NULL,
    classe_id INT NOT NULL,
    annee_universitaire_id INT NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en_cours', 'completee', 'abandonnee') DEFAULT 'en_cours',
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (classe_id) REFERENCES classes(id),
    FOREIGN KEY (annee_universitaire_id) REFERENCES annees_universitaires(id),
    UNIQUE KEY unique_inscription (etudiant_id, classe_id, annee_universitaire_id),
    INDEX idx_etudiant (etudiant_id),
    INDEX idx_classe (classe_id)
);

-- =====================================================
-- TABLE NOTES
-- =====================================================
CREATE TABLE notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    etudiant_id INT NOT NULL,
    module_id INT NOT NULL,
    cc DECIMAL(5, 2),
    tp DECIMAL(5, 2),
    examen DECIMAL(5, 2),
    moyenne DECIMAL(5, 2),
    mention VARCHAR(50),
    decision VARCHAR(100),
    date_enregistrement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE,
    UNIQUE KEY unique_note (etudiant_id, module_id),
    INDEX idx_etudiant (etudiant_id),
    INDEX idx_module (module_id)
);

-- =====================================================
-- TABLE SALLES
-- =====================================================
CREATE TABLE salles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(50) NOT NULL UNIQUE,
    capacite INT NOT NULL,
    type_salle VARCHAR(100),
    batiment VARCHAR(100),
    equipements TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- TABLE EMPLOI DU TEMPS
-- =====================================================
CREATE TABLE emploi_temps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jour ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche') NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    salle_id INT NOT NULL,
    classe_id INT NOT NULL,
    enseignant_id INT NOT NULL,
    module_id INT NOT NULL,
    annee_universitaire_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (salle_id) REFERENCES salles(id),
    FOREIGN KEY (classe_id) REFERENCES classes(id),
    FOREIGN KEY (enseignant_id) REFERENCES enseignants(id),
    FOREIGN KEY (module_id) REFERENCES modules(id),
    FOREIGN KEY (annee_universitaire_id) REFERENCES annees_universitaires(id),
    INDEX idx_classe (classe_id),
    INDEX idx_jour (jour)
);

-- =====================================================
-- TABLE PAIEMENTS
-- =====================================================
CREATE TABLE paiements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    etudiant_id INT NOT NULL,
    montant_total DECIMAL(10, 2) NOT NULL,
    montant_paye DECIMAL(10, 2) DEFAULT 0,
    reste_a_payer DECIMAL(10, 2) NOT NULL,
    date_paiement DATE,
    mode_paiement VARCHAR(50),
    reference VARCHAR(100),
    statut ENUM('en_attente', 'paye', 'partiel') DEFAULT 'en_attente',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    INDEX idx_etudiant (etudiant_id),
    INDEX idx_date_paiement (date_paiement)
);

-- =====================================================
-- TABLE RELEVÉS DE NOTES
-- =====================================================
CREATE TABLE releves_notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    etudiant_id INT NOT NULL,
    annee_universitaire_id INT NOT NULL,
    moyenne_generale DECIMAL(5, 2),
    nombre_modules_reussis INT,
    nombre_modules_total INT,
    taux_reussite DECIMAL(5, 2),
    decision_finale VARCHAR(100),
    date_generation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (annee_universitaire_id) REFERENCES annees_universitaires(id),
    UNIQUE KEY unique_releve (etudiant_id, annee_universitaire_id)
);

-- =====================================================
-- TABLE JOURNAL DES ACTIONS (AUDIT)
-- =====================================================
CREATE TABLE journal_actions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    action VARCHAR(255) NOT NULL,
    details TEXT,
    adresse_ip VARCHAR(50),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL,
    INDEX idx_timestamp (timestamp),
    INDEX idx_utilisateur (utilisateur_id)
);

-- =====================================================
-- TABLE JOURNAL DE CONNEXION
-- =====================================================
CREATE TABLE journal_connexions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    date_connexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_deconnexion TIMESTAMP,
    adresse_ip VARCHAR(50),
    navigateur VARCHAR(255),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL,
    INDEX idx_date_connexion (date_connexion)
);

-- =====================================================
-- INSÉRER LES DONNÉES PAR DÉFAUT
-- =====================================================

-- Insérer une année universitaire par défaut
INSERT INTO annees_universitaires (annee, date_debut, date_fin, actuelle) VALUES
('2024-2025', '2024-09-01', '2025-06-30', TRUE);

-- Insérer un administrateur par défaut
-- Email: admin@suptech.com, Password: Admin@123
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id) VALUES
('Admin', 'SuperAdmin', 'admin@suptech.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- =====================================================
-- CRÉER DES INDEX SUPPLÉMENTAIRES POUR OPTIMISER LES REQUÊTES
-- =====================================================
CREATE INDEX idx_utilisateur_role ON utilisateurs(role_id);
CREATE INDEX idx_etudiant_classe ON etudiants(classe_id);
CREATE INDEX idx_note_etudiant_module ON notes(etudiant_id, module_id);
CREATE INDEX idx_paiement_etudiant ON paiements(etudiant_id);

-- =====================================================
-- FIN DU SCRIPT
-- =====================================================
