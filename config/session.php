<?php
/**
 * Gestion des sessions de sécurité
 */

// Démarrer la session avec des paramètres sécurisés
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
    // Paramètres de sécurité
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 0); // À définir à 1 en HTTPS
    ini_set('session.cookie_samesite', 'Strict');
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

/**
 * Vérifier l'expiration de la session
 */
function checkSessionTimeout() {
    $timeout = 1800; // 30 minutes
    
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        session_unset();
        session_destroy();
        return false;
    }
    
    $_SESSION['last_activity'] = time();
    return true;
}

/**
 * Régénérer l'ID de session (prévention de fixation)
 */
function regenerateSession() {
    session_regenerate_id(true);
}

/**
 * Détruire la session
 */
function destroySession() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

?>
