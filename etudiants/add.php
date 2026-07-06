<?php
/**
 * Ajout d'un nouvel étudiant
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

$page_title = "Ajouter un Étudiant";
$error = '';
$success = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données
    $nom = cleanInput($_POST['nom'] ?? '');
    $prenom = cleanInput($_POST['prenom'] ?? '');
    $date_naissance = cleanInput($_POST['date_naissance'] ?? '');
    $sexe = cleanInput($_POST['sexe'] ?? '');
    $telephone = cleanInput($_POST['telephone'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $adresse = cleanInput($_POST['adresse'] ?? '');
    $classe_id = (int)($_POST['classe_id'] ?? 0);
    
    // Validation
    $validation_errors = [];
    
    if (empty($nom)) $validation_errors[] = 'Le nom est obligatoire';
    if (empty($prenom)) $validation_errors[] = 'Le prénom est obligatoire';
    if (empty($date_naissance)) $validation_errors[] = 'La date de naissance est obligatoire';
    if (empty($sexe)) $validation_errors[] = 'Le sexe est obligatoire';
    if (!empty($email) && !isValidEmail($email)) $validation_errors[] = 'Email invalide';
    if (!empty($telephone) && !isValidPhone($telephone)) $validation_errors[] = 'Téléphone invalide';
    if ($classe_id == 0) $validation_errors[] = 'Veuillez sélectionner une classe';
    
    // Vérifier que l'effectif max de la classe n'est pas atteint
    if ($classe_id > 0) {
        $class_query = "SELECT effectif_max, effectif_actuel FROM classes WHERE id = $classe_id";
        $class_result = mysqli_query($conn, $class_query);
        if ($class_result && mysqli_num_rows($class_result) > 0) {
            $class_data = mysqli_fetch_assoc($class_result);
            if ($class_data['effectif_actuel'] >= $class_data['effectif_max']) {
                $validation_errors[] = 'L\'effectif maximum de cette classe est atteint';
            }
        }
    }
    
    if (empty($validation_errors)) {
        // Générer le matricule
        $matricule = generateMatricule('STU');
        
        // Préparer la requête d'insertion
        $query = "INSERT INTO etudiants (matricule, nom, prenom, date_naissance, sexe, telephone, email, adresse, classe_id)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssi", $matricule, $nom, $prenom, $date_naissance, $sexe, $telephone, $email, $adresse, $classe_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $etudiant_id = mysqli_insert_id($conn);
            
            // Mettre à jour l'effectif de la classe
            $update_query = "UPDATE classes SET effectif_actuel = effectif_actuel + 1 WHERE id = $classe_id";
            mysqli_query($conn, $update_query);
            
            // Enregistrer l'action
            logAction($_SESSION['user_id'], 'Ajout étudiant', "Ajout de l'étudiant $nom $prenom (ID: $etudiant_id)");
            
            displaySuccess("Étudiant ajouté avec succès ! Matricule : $matricule");
            
            // Redirection après 2 secondes
            header("refresh:2;url=index.php");
        } else {
            $error = 'Erreur lors de l\'ajout de l\'étudiant';
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
        <h1><i class="fas fa-user-plus"></i> Ajouter un nouvel Étudiant</h1>
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
        <h5 class="card-title"><i class="fas fa-form-icon"></i> Formulaire d'enregistrement</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="" onsubmit="return validateForm('studentForm')">
            <div id="studentForm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control" id="nom" name="nom" 
                               required value="<?php echo htmlspecialchars($nom ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" 
                               required value="<?php echo htmlspecialchars($prenom ?? ''); ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_naissance" class="form-label">Date de naissance *</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" 
                               required value="<?php echo htmlspecialchars($date_naissance ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="sexe" class="form-label">Sexe *</label>
                        <select class="form-select" id="sexe" name="sexe" required>
                            <option value="">Sélectionner...</option>
                            <option value="M" <?php echo isset($sexe) && $sexe === 'M' ? 'selected' : ''; ?>>Masculin</option>
                            <option value="F" <?php echo isset($sexe) && $sexe === 'F' ? 'selected' : ''; ?>>Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($email ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" 
                               data-type="phone" value="<?php echo htmlspecialchars($telephone ?? ''); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <textarea class="form-control" id="adresse" name="adresse" rows="3"><?php echo htmlspecialchars($adresse ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="classe_id" class="form-label">Classe *</label>
                    <select class="form-select" id="classe_id" name="classe_id" required>
                        <option value="">Sélectionner une classe...</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>" 
                                    <?php echo isset($classe_id) && $classe_id == $class['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['nom']); ?> 
                                (<?php echo $class['effectif_actuel']; ?>/<?php echo $class['effectif_max']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <small class="text-muted">* Champs obligatoires</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<script>
// Validation supplémentaire côté client
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date_naissance');
    
    // Limiter la date de naissance à 18 ans minimum
    dateInput.addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            const calculatedAge = age - 1;
        } else {
            const calculatedAge = age;
        }
        
        if (age < 16) {
            showNotification('L\'étudiant doit avoir au minimum 16 ans', 'warning');
        }
    });
});
</script>
