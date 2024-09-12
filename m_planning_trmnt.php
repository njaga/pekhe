<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$id = htmlspecialchars($_POST['id']);
$date_planning = htmlspecialchars($_POST['date_planning']);
$id_site = htmlspecialchars($_POST['site']);
$employe = htmlspecialchars($_POST['employe']);

$horaire_lundi = $_POST['horaire_lundi'];
$horaire_mardi = $_POST['horaire_mardi'];
$horaire_mercredi = $_POST['horaire_mercredi'];
$horaire_jeudi = $_POST['horaire_jeudi'];
$horaire_vendredi = $_POST['horaire_vendredi'];
$horaire_samedi = $_POST['horaire_samedi'];
$horaire_dimanche = $_POST['horaire_dimanche'];
$observation = $_POST['observation'];



$req_update = $db->prepare('UPDATE planning_agent SET etat=0, date_fin=? WHERE id_agent=?');
$req_update->execute(array($date_planning, $employe));


$reponse = $db->prepare("INSERT INTO `planning_agent`( `date_debut`, `lundi`, `mardi`, `mercredi`, `jeudi`, `vendredi`, `samedi`, `dimanche`, `id_agent`, `id_site`, `id_user`, observation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_planning, $horaire_lundi, $horaire_mardi, $horaire_mercredi, $horaire_jeudi, $horaire_vendredi, $horaire_samedi, $horaire_dimanche, $employe, $id_site, $_SESSION['id_vigilus_user'], $observation)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

$id_planning = $db->lastInsertId();




if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.history.go(-2);
        //window.location="e_abs_remp.php";
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