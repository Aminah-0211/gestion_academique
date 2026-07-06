<?php
/**
 * Suppression d'un étudiant
 */

require_once('../config/session.php');
require_once('../config/database.php');
require_once('../config/functions.php');

// Vérifier l'authentification
if (!isLoggedIn()) {
    redirect('/auth/login.php');
}

// Vérifier les permissions
if (!hasRole('Administrateur') && !hasRole('Scolarité')) {
    die('Accès refusé');
}

$etudiant_id = (int)($_GET['id'] ?? 0);
if ($etudiant_id == 0) {
    displayError('Étudiant non trouvé');
    redirect('/etudiants/');
}

// Récupérer les données de l'étudiant
$query = "SELECT * FROM etudiants WHERE id = $etudiant_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    displayError('Étudiant non trouvé');
    redirect('/etudiants/');
}

$etudiant = mysqli_fetch_assoc($result);

// Supprimer l'étudiant
$delete_query = "DELETE FROM etudiants WHERE id = $etudiant_id";

if (mysqli_query($conn, $delete_query)) {
    // Mettre à jour l'effectif de la classe
    if ($etudiant['classe_id'] > 0) {
        mysqli_query($conn, "UPDATE classes SET effectif_actuel = GREATEST(0, effectif_actuel - 1) WHERE id = " . $etudiant['classe_id']);
    }
    
    // Enregistrer l'action
    logAction($_SESSION['user_id'], 'Suppression étudiant', 
              "Suppression de l'étudiant " . htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']) . 
              " (Matricule: " . htmlspecialchars($etudiant['matricule']) . ")");
    
    displaySuccess("Étudiant supprimé avec succès !");
} else {
    displayError('Erreur lors de la suppression de l\'étudiant');
}

redirect('/etudiants/');
?>
