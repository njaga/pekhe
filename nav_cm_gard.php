

<!--Navbar -->
<header>
  <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar primary-color mb-5">
    <a class="navbar-brand" href="accueil.php"><b>Pékhé</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
      aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
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
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Affectations
          </a>
          <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="l_affectation_employe.php">Nouvelle +</a>
            <a class="dropdown-item" href="l_affectation_site.php">Liste affectations</a>
          </div>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Sites gardiennage
          </a>
          <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="l_site.php">Liste sites</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Absences/Remplacements
          </a>
          <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="e_abs_remp.php">Ajouter +</a>
            <a class="dropdown-item" href="l_abs_remp.php">Liste </a>
          </div>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Contrôle des sites
          </a>
          <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="e_controle_site.php">Enregistrer</a>
            <a class="dropdown-item" href="l_controle_site.php">Rapport contrôle</a>
          </div>
        </li>
        
        
      </ul>
      <ul class="navbar-nav ml-auto nav-flex-icons">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"> <?= $_SESSION['nom_vigilus_user'] ?></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right "
            aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="deconnexion.php">Déconnexion</a>
            <a class="dropdown-item" href="m_pwd.php?id=<?=$_SESSION['id_vigilus_user'] ?>">Modifier mot de passe</a>
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
.dropdown-item:hover {background-color: #4285F4 !important;}
</style>