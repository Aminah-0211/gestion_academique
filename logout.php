<?php
/**
 * Page de déconnexion
 */

require_once('config/session.php');

// Enregistrer la déconnexion dans le journal
if (isset($_SESSION['user_id'])) {
    require_once('config/database.php');
    
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE journal_connexions SET date_deconnexion = NOW() 
              WHERE utilisateur_id = ? AND date_deconnexion IS NULL 
              ORDER BY date_connexion DESC LIMIT 1";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
}

// Détruire la session
destroySession();

// Rediriger vers la page de connexion
header("Location: /auth/login.php?logout=1");
exit();
?>
