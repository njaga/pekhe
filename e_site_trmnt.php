<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$nom = htmlspecialchars(suppr_accents($_POST['nom']));
$localisation = htmlspecialchars(suppr_accents($_POST['localisation']));
$date_debut = htmlspecialchars(suppr_accents($_POST['date_debut']));
$departement = htmlspecialchars(suppr_accents($_POST['departement']));

$reponse = $db->prepare("INSERT INTO `site`(`nom`, `localisation`, `date_debut`, `id_departement`, `id_user`) VALUES (?,?,?,?,?)");
$reponse->execute(array($nom, $localisation, $date_debut, $departement, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();


if ($nbr > 0) {
?>
    <script type="text/javascript">
        alert("Site enregistré");
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : Site non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>