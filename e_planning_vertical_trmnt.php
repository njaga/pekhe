<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$id_site = htmlspecialchars($_POST['site']);
$employe = htmlspecialchars($_POST['employe']);
$observation = htmlspecialchars($_POST['observation']);
$mois = htmlspecialchars($_POST['mois']);
$annee = htmlspecialchars($_POST['annee']);

$joursChoisis = isset($_POST["jours"]) ? $_POST["jours"] : [];

// Tableau associatif pour stocker les choix "Jour" ou "Nuit" pour chaque jour
$joursChoisis = isset($_POST["jours"]) ? $_POST["jours"] : [];

// Boucle pour récupérer les choix pour chaque jour
foreach ($joursChoisis as $jour) {
    // Récupérer la valeur du radio button correspondant au jour
    $periode = isset($_POST["periode" . $jour]) ? $_POST["periode" . $jour] : "";

    // Stocker le choix dans le tableau associatif
    $choixPeriode[$jour] = $periode;
}

foreach ($choixPeriode as $jour => $periode) {
    $date_planning = $annee . "-" . $mois . "-" . $jour;
    $reponse = $db->prepare("INSERT INTO `planning_vertical`(`id_agent`, `id_site`, `planning`, `id_user`, `date_planning`, observation) VALUES (?,?,?,?,?,?)");
    $reponse->execute(array($employe, $id_site, $periode, $_SESSION['id_vigilus_user'], $date_planning, $observation)) or die(print_r($reponse->errorInfo()));
}

$nbr = $reponse->rowCount();
$id_planning = $db->lastInsertId();




if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.location = "e_planning_vertical.php";
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : opération non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>