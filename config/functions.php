<?php
/**
 * Fonctions réutilisables PHP
 */

/**
 * Fonction de sécurité - Nettoyer les entrées
 */
function cleanInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

/**
 * Fonction de sécurité - Redirection sécurisée
 */
function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

/**
 * Fonction de validation - Email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Fonction de validation - Téléphone
 */
function isValidPhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 9 && strlen($phone) <= 15;
}

/**
 * Fonction de sécurité - Hachage du mot de passe
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Fonction de sécurité - Vérifier le mot de passe
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Fonction de pagination
 */
function getPaginationData($totalItems, $itemsPerPage, $currentPage) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $offset = ($currentPage - 1) * $itemsPerPage;
    
    return [
        'totalPages' => $totalPages,
        'offset' => $offset,
        'limit' => $itemsPerPage,
        'currentPage' => $currentPage
    ];
}

/**
 * Fonction de formatage - Date
 */
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

/**
 * Fonction de formatage - Devise
 */
function formatCurrency($amount) {
    return number_format($amount, 2, ',', ' ') . ' FCFA';
}

/**
 * Fonction de génération de matricule
 */
function generateMatricule($prefix) {
    return $prefix . '-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
}

/**
 * Fonction de gestion des messages d'erreur
 */
function displayError($message) {
    $_SESSION['error'] = $message;
}

/**
 * Fonction de gestion des messages de succès
 */
function displaySuccess($message) {
    $_SESSION['success'] = $message;
}

/**
 * Fonction de vérification des rôles
 */
function hasRole($requiredRole) {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    return $_SESSION['user_role'] === $requiredRole || $_SESSION['user_role'] === 'Administrateur';
}

/**
 * Fonction d'enregistrement d'actions (audit)
 */
function logAction($userId, $action, $details = '') {
    global $conn;
    
    $timestamp = date('Y-m-d H:i:s');
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    
    $query = "INSERT INTO journal_actions (utilisateur_id, action, details, adresse_ip, timestamp) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issss", $userId, $action, $details, $ipAddress, $timestamp);
    
    return mysqli_stmt_execute($stmt);
}

?>
