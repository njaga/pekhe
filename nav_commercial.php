<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connexion.php';


//nbr de congés en attente de validation du chef de département
$req_val_cdep = $db->query("SELECT COUNT(demande_conges.id)
FROM `demande_conges`
INNER JOIN employe on employe.id=demande_conges.id_employe
WHERE demande_conges.etat=1 AND employe.id_departement=2");
$donnees_val_cdep = $req_val_cdep->fetch();
$nbr_val_cdep = $donnees_val_cdep['0'];

//nbr de congés en attente de validation direction
$req_val_rh = $db->query("SELECT COUNT(demande_conges.id)
FROM `demande_conges`
WHERE demande_conges.etat=2 ");
$donnees_val_rh = $req_val_rh->fetch();
$nbr_val_rh = $donnees_val_rh['0'];

?>
<!--Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar blue darken-4 mb-5">
        <a class="navbar-brand" href="accueil.php"><b>Pékhé</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
                <!--
              <li class="nav-item active">
                <a class="nav-link" href="#">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Congès
                        <?php
                        if ($nbr_val_cdep > 0) {
                            echo '<span class="badge red">' . $nbr_val_cdep . '</span>';
                        }
                        ?>
                    </a>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="demande_conges.php">Nouvelle +</a>
                        <?php
                        if ($_SESSION['id_manager_departement'] == $_SESSION['id_employe']) {
                        ?>
                            <a class="dropdown-item" href="l_demande_conges.php">Demandes département</a>
                        <?php
                        }
                        ?>
                    </div>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"> <?php echo strtoupper(substr($_SESSION['prenon_vigilus_user'], 0, 1)) . "." . ucfirst($_SESSION['nom_vigilus_user']) ?></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="deconnexion.php">Déconnexion</a>
                        <a class="dropdown-item" href="m_pwd.php?id=<?= $_SESSION['id_vigilus_user'] ?>">Modifier mot de
                            passe</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--/.Navbar -->
<style type="text/css">
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }

    .dropdown-item:hover {
        background-color: #0d47a1 !important;
    }
</style>