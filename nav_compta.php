<!--Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar primary-color mb-5">
        <a class="navbar-brand" href="accueil.php"><b>Pékhé&nbsp</b><sub>Compta</sub></a>
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
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Employés
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="n_recrue.php">Nouvelle recrue(s)</a>
                        <a class="dropdown-item" href="n_demission.php">Démission</a>
                        <a class="dropdown-item" href="l_employe.php">Liste Employés</a>
                        <a class="dropdown-item" href="l_emp_gardiennage.php">Service gardiennage</a>
                        <a class="dropdown-item" href="l_emp_nettoyage.php">Service nettoyage</a>
                        <a class="dropdown-item" href="salaire.php">Salaire(s)<span class="badge bg-danger ms-5"> New</span></a>
                        <a class="dropdown-item" href="l_emp_contr.php">Contrat(s)</a>
                        <a class="dropdown-item" href="l_sanction.php">Sanction(s)</a>
                        <a class="dropdown-item" href="l_emp_archive.php">Archives</a>
                        <a class="dropdown-item" href="statistique_employe.php">Statistiques</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Accompte(s)
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="accompte.php">Etat accompte(s)</a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sites gardiennage
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="l_site.php">Liste sites</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Absences/Remplacements
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="l_abs_remp.php">Liste </a>
                        <a class="dropdown-item" href="statistique_abs.php">Statistique(s) </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Finance
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="etat_caisse.php">Etat caisse</a>
                        <a class="dropdown-item" href="etat_banque_bis.php">Etat Banque BIS</a>
                        <a class="dropdown-item" href="etat_banque_coris.php">Etat Banque CORIS</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dépenses(s)
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="l_depenses.php">Dépenses(s)</a>
                        <a class="dropdown-item" href="l_depenses_att.php">En attente</a>
                        <a class="dropdown-item" href="l_projet.php">Projet(s)</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Congès  
                        <?php
                        if($nbr_val_cdep>0)
                        {
                            echo '<span class="badge red">'.$nbr_val_cdep .'</span>';
                        }
                        ?>
                    </a>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="demande_conges.php">Nouvelle +</a>
                        <?php
                        if($_SESSION['id_manager_departement']==$_SESSION['id_employe'])
                        {
                            ?>
                        <a class="dropdown-item" href="l_demande_conges.php">Demandes département</a>
                            <?php
                        }
                        ?>
                    </div>
                </li>
                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gestion Stock
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="l_entree_art.php">Entrée(s)</a>
                        <a class="dropdown-item" href="l_sortie_art.php">Sortie(s)</a>
                    </div>
                </li>
-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Stock
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
                        <a class="dropdown-item" href="l_dotation.php">Dotation(s)</a>
                        <a class="dropdown-item" href="l_dotation_site.php">Dotation Site</a>
                        <a class="dropdown-item" href="stock_art_gar.php">Stock </a>
                        <a class="dropdown-item" href="ravitaillement.php">Ravitaillement </a>
                    </div>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"> <?php echo strtoupper(substr($_SESSION['prenon_vigilus_user'], 0,1)).".".ucfirst($_SESSION['nom_vigilus_user']) ?></i>
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

    .navbar {
        background-color: #e91e63 !important;
    }

    .dropdown-item:hover {
        background-color: #e91e63 !important;
    }
</style>