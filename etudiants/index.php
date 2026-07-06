<?php
/**
 * Gestion des Étudiants - Liste et Recherche
 */

require_once('../config/session.php');
require_once('../config/database.php');
require_once('../config/functions.php');

// Vérifier l'authentification
if (!isLoggedIn()) {
    redirect('/auth/login.php');
}

// Vérifier les permissions (Administrateur ou Scolarité)
if (!hasRole('Administrateur') && !hasRole('Scolarité')) {
    die('Accès refusé');
}

$page_title = "Gestion des Étudiants";
$search = '';
$class_filter = '';
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Traitement de la recherche
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['search'])) {
    $search = isset($_POST['search']) ? cleanInput($_POST['search']) : (isset($_GET['search']) ? cleanInput($_GET['search']) : '');
    $class_filter = isset($_POST['class_filter']) ? cleanInput($_POST['class_filter']) : (isset($_GET['class_filter']) ? cleanInput($_GET['class_filter']) : '');
}

// Construire la requête de base
$where_clause = "WHERE e.statut = 'actif'";

if ($search) {
    $where_clause .= " AND (e.matricule LIKE '%$search%' 
                           OR e.nom LIKE '%$search%' 
                           OR e.prenom LIKE '%$search%' 
                           OR e.email LIKE '%$search%')";
}

if ($class_filter) {
    $where_clause .= " AND e.classe_id = $class_filter";
}

// Compter le total des résultats
$count_query = "SELECT COUNT(*) as total FROM etudiants e $where_clause";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_items = $count_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// Récupérer les données paginées
$offset = ($current_page - 1) * $items_per_page;
$query = "SELECT e.*, c.nom as classe_nom 
          FROM etudiants e
          LEFT JOIN classes c ON e.classe_id = c.id
          $where_clause
          ORDER BY e.date_inscription DESC
          LIMIT $items_per_page OFFSET $offset";

$result = mysqli_query($conn, $query);

// Récupérer les classes pour le filtre
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
    <div class="col-md-8">
        <h1><i class="fas fa-user-graduate"></i> Gestion des Étudiants</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="add.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Ajouter un étudiant
        </a>
    </div>
</div>

<!-- Formulaire de recherche -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title"><i class="fas fa-search"></i> Recherche</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Rechercher par matricule, nom, email..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-4">
                    <select name="class_filter" class="form-select">
                        <option value="">Toutes les classes</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>" 
                                    <?php echo ($class_filter == $class['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Liste des étudiants -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title">
            <i class="fas fa-list"></i> Liste des étudiants 
            <small class="text-muted">(<?php echo $total_items; ?> résultat<?php echo $total_items > 1 ? 's' : ''; ?>)</small>
        </h5>
    </div>
    <div class="card-body">
        <?php if ($total_items > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Classe</th>
                            <th>Téléphone</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <small class="badge bg-primary">
                                        <?php echo htmlspecialchars($row['matricule']); ?>
                                    </small>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['nom'] . ' ' . $row['prenom']); ?>
                                </td>
                                <td>
                                    <small><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <small><?php echo htmlspecialchars($row['classe_nom'] ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <small><?php echo htmlspecialchars($row['telephone'] ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <small><?php echo formatDate($row['date_inscription']); ?></small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-info" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger" title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>&class_filter=<?php echo $class_filter; ?>">
                                    Première
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&search=<?php echo urlencode($search); ?>&class_filter=<?php echo $class_filter; ?>">
                                    Précédente
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php 
                        $start = max(1, $current_page - 2);
                        $end = min($total_pages, $current_page + 2);
                        
                        for ($i = $start; $i <= $end; $i++): 
                        ?>
                            <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&class_filter=<?php echo $class_filter; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&search=<?php echo urlencode($search); ?>&class_filter=<?php echo $class_filter; ?>">
                                    Suivante
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>&class_filter=<?php echo $class_filter; ?>">
                                    Dernière
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Aucun étudiant trouvé.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
