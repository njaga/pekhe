<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['id_vigilus_user'] < 1) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}


if ($_SESSION['id_departement'] == "1") {
    include 'nav_rh.php';
}
elseif ($_SESSION['id_departement'] == "2") {
    include 'nav_rh.php';
}
elseif ($_SESSION['id_departement'] == "3") {
    include 'nav_gardiennage.php';
}
elseif ($_SESSION['id_departement'] == "4") {
    include 'nav_compta.php';
}
elseif ($_SESSION['id_departement'] == "6") {
    include 'nav_electronique.php';
}
elseif ($_SESSION['id_departement'] == "7") {
    include 'nav_incendie.php';
}
elseif ($_SESSION['id_departement'] == "8") {
    include 'nav_monetique.php';
}
elseif ($_SESSION['id_departement'] == "9") {
    include 'nav_commercial.php';
}
elseif ($_SESSION['id_departement'] == "10") {
    include 'nav_qhse.php';
}
elseif ($_SESSION['id_departement'] == "11") {
    include 'nav_achat.php';
}
elseif ($_SESSION['id_departement'] == "12") {
    include 'nav_accueil.php';
}
elseif ($_SESSION['id_departement'] == "13") {
    include 'nav_direction.php';
}


/*
if ($_SESSION['profil_vigilus_user'] == "rh") {
    include 'nav_rh.php';
} elseif ($_SESSION['profil_vigilus_user'] == "cm_gardiennage") {
    include 'nav_cm_gard.php';
} elseif ($_SESSION['profil_vigilus_user'] == "r_exp") {
    include 'nav_r_exp.php';
} elseif ($_SESSION['profil_vigilus_user'] == "r_achat") {
    include 'nav_r_achat.php';
} elseif ($_SESSION['profil_vigilus_user'] == "d_tech") {
    include 'nav_d_tech.php';
} elseif ($_SESSION['profil_vigilus_user'] == "informaticien") {
    include 'nav_ad.php';
} elseif ($_SESSION['profil_vigilus_user'] == "comptabilite") {
    include 'nav_compta.php';
} elseif ($_SESSION['profil_vigilus_user'] == "res_op") {
    include 'nav_res_op.php';
} elseif ($_SESSION['profil_vigilus_user'] == "assistante_direction") {
    include 'nav_secretaire.php';
} elseif ($_SESSION['profil_vigilus_user'] == "direction") {
    include 'nav_direction.php';
} elseif ($_SESSION['profil_vigilus_user'] == "logistique") {
    include 'nav_logistique.php';
} elseif ($_SESSION['profil_vigilus_user'] == "ass_op") {
    include 'nav_ass_op.php';
} elseif ($_SESSION['profil_vigilus_user'] == "philo") {
    include 'nav_philo.php';
}
 elseif ($_SESSION['profil_vigilus_user'] == "r_it") {
    include 'nav_it.php';
}
*/