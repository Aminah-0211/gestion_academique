<?php
/**
 * Page d'accueil principale
 * Tableau de bord après connexion ou redirection vers login
 */

require_once('config/session.php');
require_once('config/database.php');
require_once('config/functions.php');

// Vérifier la session
if (!isLoggedIn()) {
    redirect('/auth/login.php');
}

// Vérifier le timeout
if (!checkSessionTimeout()) {
    redirect('/auth/login.php');
}

$page_title = "Tableau de Bord";
?>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<!-- Contenu principal -->
<div class="row mb-4 mt-4">
    <div class="col-md-12">
        <h1 class="mb-4">
            <i class="fas fa-tachometer-alt"></i> Tableau de Bord
        </h1>
    </div>
</div>

<!-- Statistiques principales -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="number">
                <i class="fas fa-user-graduate"></i>
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM etudiants WHERE statut='actif'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
            </div>
            <div class="label">Étudiants Actifs</div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="number">
                <i class="fas fa-chalkboard-user"></i>
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM enseignants");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
            </div>
            <div class="label">Enseignants</div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="number">
                <i class="fas fa-door-open"></i>
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM classes");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
            </div>
            <div class="label">Classes</div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="number">
                <i class="fas fa-book"></i>
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM modules");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
            </div>
            <div class="label">Modules</div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="number">
                <i class="fas fa-clipboard-list"></i>
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM inscriptions WHERE statut='en_cours'");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
            </div>
            <div class="label">Inscriptions Actives</div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-secondary text-white">
            <div class="number">
                <i class="fas fa-credit-card"></i>
                <?php
                $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM paiements WHERE statut IN ('paye', 'partiel')");
                $row = mysqli_fetch_assoc($result);
                echo $row['total'];
                ?>
            </div>
            <div class="label">Paiements Traités</div>
        </div>
    </div>
</div>

<!-- Derniers étudiants inscrits -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-user-plus"></i> Derniers Étudiants Inscrits
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Classe</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT e.matricule, e.nom, e.prenom, c.nom as classe_nom, e.date_inscription
                                      FROM etudiants e
                                      JOIN classes c ON e.classe_id = c.id
                                      ORDER BY e.date_inscription DESC
                                      LIMIT 5";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td><small>" . htmlspecialchars($row['matricule']) . "</small></td>";
                                echo "<td>" . htmlspecialchars($row['nom'] . ' ' . $row['prenom']) . "</td>";
                                echo "<td><small>" . htmlspecialchars($row['classe_nom']) . "</small></td>";
                                echo "<td><small>" . formatDate($row['date_inscription']) . "</small></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dernières notes enregistrées -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-star"></i> Dernières Notes Enregistrées
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>Module</th>
                                <th>Moyenne</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT e.nom, e.prenom, m.nom as module_nom, n.moyenne, n.date_enregistrement
                                      FROM notes n
                                      JOIN etudiants e ON n.etudiant_id = e.id
                                      JOIN modules m ON n.module_id = m.id
                                      ORDER BY n.date_enregistrement DESC
                                      LIMIT 5";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['nom'] . ' ' . $row['prenom']) . "</td>";
                                echo "<td><small>" . htmlspecialchars($row['module_nom']) . "</small></td>";
                                echo "<td><span class='badge bg-primary'>" . $row['moyenne'] . "</span></td>";
                                echo "<td><small>" . formatDate($row['date_enregistrement']) . "</small></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
