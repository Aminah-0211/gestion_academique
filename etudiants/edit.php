<?php
/**
 * Modification d'un étudiant
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
    die('Étudiant non trouvé');
}

$page_title = "Modifier un Étudiant";
$error = '';
$success = '';

// Récupérer les données de l'étudiant
$query = "SELECT * FROM etudiants WHERE id = $etudiant_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die('Étudiant non trouvé');
}

$etudiant = mysqli_fetch_assoc($result);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = cleanInput($_POST['nom'] ?? '');
    $prenom = cleanInput($_POST['prenom'] ?? '');
    $date_naissance = cleanInput($_POST['date_naissance'] ?? '');
    $sexe = cleanInput($_POST['sexe'] ?? '');
    $telephone = cleanInput($_POST['telephone'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $adresse = cleanInput($_POST['adresse'] ?? '');
    $classe_id = (int)($_POST['classe_id'] ?? 0);
    $statut = cleanInput($_POST['statut'] ?? 'actif');
    
    // Validation
    $validation_errors = [];
    
    if (empty($nom)) $validation_errors[] = 'Le nom est obligatoire';
    if (empty($prenom)) $validation_errors[] = 'Le prénom est obligatoire';
    if (empty($date_naissance)) $validation_errors[] = 'La date de naissance est obligatoire';
    if (empty($sexe)) $validation_errors[] = 'Le sexe est obligatoire';
    if (!empty($email) && !isValidEmail($email)) $validation_errors[] = 'Email invalide';
    if (!empty($telephone) && !isValidPhone($telephone)) $validation_errors[] = 'Téléphone invalide';
    if ($classe_id == 0) $validation_errors[] = 'Veuillez sélectionner une classe';
    
    // Vérifier si l'email n'existe pas ailleurs
    $email_check = "SELECT id FROM etudiants WHERE email = '$email' AND id != $etudiant_id LIMIT 1";
    $email_result = mysqli_query($conn, $email_check);
    if ($email_result && mysqli_num_rows($email_result) > 0) {
        $validation_errors[] = 'Cet email est déjà utilisé par un autre étudiant';
    }
    
    if (empty($validation_errors)) {
        $query = "UPDATE etudiants 
                  SET nom = ?, prenom = ?, date_naissance = ?, sexe = ?, 
                      telephone = ?, email = ?, adresse = ?, classe_id = ?, statut = ?
                  WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssi", $nom, $prenom, $date_naissance, $sexe, $telephone, $email, $adresse, $classe_id, $etudiant_id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Si la classe a changé, mettre à jour les effectifs
            if ($etudiant['classe_id'] != $classe_id) {
                mysqli_query($conn, "UPDATE classes SET effectif_actuel = effectif_actuel - 1 WHERE id = " . $etudiant['classe_id']);
                mysqli_query($conn, "UPDATE classes SET effectif_actuel = effectif_actuel + 1 WHERE id = $classe_id");
            }
            
            // Enregistrer l'action
            logAction($_SESSION['user_id'], 'Modification étudiant', "Modification de l'étudiant $nom $prenom (ID: $etudiant_id)");
            
            displaySuccess("Étudiant modifié avec succès !");
            
            // Récupérer les données mises à jour
            $result = mysqli_query($conn, "SELECT * FROM etudiants WHERE id = $etudiant_id");
            $etudiant = mysqli_fetch_assoc($result);
        } else {
            $error = 'Erreur lors de la modification de l\'étudiant';
        }
    } else {
        $error = implode('<br>', $validation_errors);
    }
}

// Récupérer les classes
$classes_query = "SELECT * FROM classes ORDER BY nom";
$classes_result = mysqli_query($conn, $classes_query);
$classes = [];
while ($row = mysqli_fetch_assoc($classes_result)) {
    $classes[] = $row;
}

?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>

<div class="row mb-4 mt-4">
    <div class="col-md-12">
        <h1><i class="fas fa-edit"></i> Modifier l'Étudiant</h1>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">
            <i class="fas fa-info-circle"></i> 
            <?php echo htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']); ?> 
            - Matricule : <?php echo htmlspecialchars($etudiant['matricule']); ?>
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" 
                           required value="<?php echo htmlspecialchars($etudiant['nom']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom *</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" 
                           required value="<?php echo htmlspecialchars($etudiant['prenom']); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_naissance" class="form-label">Date de naissance *</label>
                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" 
                           required value="<?php echo htmlspecialchars($etudiant['date_naissance']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="sexe" class="form-label">Sexe *</label>
                    <select class="form-select" id="sexe" name="sexe" required>
                        <option value="M" <?php echo $etudiant['sexe'] === 'M' ? 'selected' : ''; ?>>Masculin</option>
                        <option value="F" <?php echo $etudiant['sexe'] === 'F' ? 'selected' : ''; ?>>Féminin</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?php echo htmlspecialchars($etudiant['email'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" 
                           value="<?php echo htmlspecialchars($etudiant['telephone'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <textarea class="form-control" id="adresse" name="adresse" rows="3"><?php echo htmlspecialchars($etudiant['adresse'] ?? ''); ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="classe_id" class="form-label">Classe *</label>
                    <select class="form-select" id="classe_id" name="classe_id" required>
                        <option value="">Sélectionner une classe...</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>" 
                                    <?php echo $etudiant['classe_id'] == $class['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select" id="statut" name="statut">
                        <option value="actif" <?php echo $etudiant['statut'] === 'actif' ? 'selected' : ''; ?>>Actif</option>
                        <option value="suspendu" <?php echo $etudiant['statut'] === 'suspendu' ? 'selected' : ''; ?>>Suspendu</option>
                        <option value="gradué" <?php echo $etudiant['statut'] === 'gradué' ? 'selected' : ''; ?>>Gradué</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
