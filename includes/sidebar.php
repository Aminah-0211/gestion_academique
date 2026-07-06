    <!-- Barre latérale -->
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/dashboard/">
                                <i class="fas fa-chart-line"></i> Tableau de Bord
                            </a>
                        </li>
                        
                        <?php if (hasRole('Administrateur') || hasRole('Scolarité')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/etudiants/">
                                    <i class="fas fa-user-graduate"></i> Étudiants
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/classes/">
                                    <i class="fas fa-door-open"></i> Classes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/inscriptions/">
                                    <i class="fas fa-clipboard-list"></i> Inscriptions
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (hasRole('Administrateur')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/enseignants/">
                                    <i class="fas fa-chalkboard-user"></i> Enseignants
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/modules/">
                                    <i class="fas fa-book"></i> Modules
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/emplois/">
                                    <i class="fas fa-calendar"></i> Emploi du Temps
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/salles/">
                                    <i class="fas fa-door-closed"></i> Salles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/paiements/">
                                    <i class="fas fa-credit-card"></i> Paiements
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/statistiques/">
                                    <i class="fas fa-chart-bar"></i> Statistiques
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (hasRole('Administrateur') || hasRole('Enseignant')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo SITE_URL; ?>/notes/">
                                    <i class="fas fa-star"></i> Notes
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <hr class="my-3">
                        
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?php echo SITE_URL; ?>/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
