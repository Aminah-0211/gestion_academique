<?php
/**
 * Page de connexion
 */

require_once('../config/session.php');
require_once('../config/database.php');
require_once('../config/functions.php');

// Si déjà connecté, rediriger vers le tableau de bord
if (isLoggedIn()) {
    redirect('/index.php');
}

$error = '';
$success = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';
    } elseif (!isValidEmail($email)) {
        $error = 'Email invalide';
    } else {
        // Vérifier les identifiants dans la base de données
        $query = "SELECT u.id, u.nom, u.prenom, u.mot_de_passe, u.statut, r.nom as role 
                  FROM utilisateurs u
                  JOIN roles r ON u.role_id = r.id
                  WHERE u.email = ? AND u.statut = 'actif'";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Vérifier le mot de passe
            if (verifyPassword($password, $user['mot_de_passe'])) {
                // Mot de passe correct
                regenerateSession();
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $user['role'];
                
                // Enregistrer la connexion dans le journal
                $ip = $_SERVER['REMOTE_ADDR'];
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                $query_log = "INSERT INTO journal_connexions (utilisateur_id, adresse_ip, navigateur) 
                             VALUES (?, ?, ?)";
                
                $stmt_log = mysqli_prepare($conn, $query_log);
                mysqli_stmt_bind_param($stmt_log, "iss", $user['id'], $ip, $user_agent);
                mysqli_stmt_execute($stmt_log);
                
                // Redirection
                redirect('/index.php');
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        } else {
            $error = 'Email ou mot de passe incorrect';
        }
    }
}

$page_title = "Connexion";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        
        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        
        .login-card .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px 12px 0 0;
            border: none;
            padding: 30px 20px;
            text-align: center;
        }
        
        .login-card .card-header h3 {
            color: #fff;
            margin: 0;
            font-weight: 700;
        }
        
        .login-card .card-header p {
            color: rgba(255, 255, 255, 0.8);
            margin-top: 10px;
            margin-bottom: 0;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-header">
                <h3><i class="fas fa-graduation-cap"></i> SupTech Académique</h3>
                <p>Système de Gestion Académique</p>
            </div>
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['logout'])): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i> Vous avez été déconnecté avec succès.
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="exemple@suptech.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Votre mot de passe" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    
                    <button type="submit" class="btn btn-login w-100 text-white">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </button>
                </form>
                
                <hr class="my-4">
                
                <p class="text-center text-muted mb-0">
                    <small>Utilisateur par défaut : <strong>admin@suptech.com</strong> / <strong>Admin@123</strong></small>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
