<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$date_planning = htmlspecialchars($_POST['date_planning']);
$id_site = htmlspecialchars($_POST['site']);
$employe = htmlspecialchars($_POST['employe']);
$multisite = htmlspecialchars($_POST['inlineRadioOptions']);

$horaire_mardi = "";
$horaire_mercredi = "";
$horaire_jeudi = "";
$horaire_vendredi = "";
$horaire_samedi = "";
$horaire_dimanche = "";
$observation = "";

if (isset($_POST['horaire_lundi'])) {
    $horaire_lundi = $_POST['horaire_lundi'];
}
if (isset($_POST['horaire_mardi'])) {
    $horaire_mardi = $_POST['horaire_mardi'];
}
if (isset($_POST['horaire_mercredi'])) {
    $horaire_mercredi = $_POST['horaire_mercredi'];
}
if (isset($_POST['horaire_jeudi'])) {
    $horaire_jeudi = $_POST['horaire_jeudi'];
}
if (isset($_POST['horaire_vendredi'])) {
    $horaire_vendredi = $_POST['horaire_vendredi'];
}
if (isset($_POST['horaire_samedi'])) {
    $horaire_samedi = $_POST['horaire_samedi'];
}
if (isset($_POST['horaire_dimanche'])) {
    $horaire_dimanche = $_POST['horaire_dimanche'];
}
$observation = $_POST['observation'];

if ($multisite == 0) {
    //Ancien planning
    $req_update = $db->prepare('UPDATE planning_agent SET etat=0, date_fin=?  WHERE id_agent=? AND etat=1');
    $req_update->execute(array($date_planning, $employe));

    $reponse = $db->prepare("INSERT INTO `planning_agent`( `date_debut`, `lundi`, `mardi`, `mercredi`, `jeudi`, `vendredi`, `samedi`, `dimanche`, `id_agent`, `id_site`, `id_user`, observation, multisite) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $reponse->execute(array($date_planning, $horaire_lundi, $horaire_mardi, $horaire_mercredi, $horaire_jeudi, $horaire_vendredi, $horaire_samedi, $horaire_dimanche, $employe, $id_site, $_SESSION['id_vigilus_user'], $observation, $multisite)) or die(print_r($reponse->errorInfo()));
    $nbr = $reponse->rowCount();
    $id_planning = $db->lastInsertId();
} else {
    //Ancien planning
    $req_update = $db->prepare('UPDATE planning_agent SET etat=0, date_fin=?  WHERE id_agent=? AND etat=1');
    $req_update->execute(array($date_planning, $employe));

    $reponse = $db->prepare("INSERT INTO `planning_agent`( `date_debut`, `lundi`, `mardi`, `mercredi`, `jeudi`, `vendredi`, `samedi`, `dimanche`, `id_agent`, `id_site`, `id_user`, observation, multisite) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $reponse->execute(array($date_planning, $horaire_lundi, $horaire_mardi, $horaire_mercredi, $horaire_jeudi, $horaire_vendredi, $horaire_samedi, $horaire_dimanche, $employe, $id_site, $_SESSION['id_vigilus_user'], $observation, $multisite)) or die(print_r($reponse->errorInfo()));
    $nbr = $reponse->rowCount();
    $id_planning = $db->lastInsertId();
}





if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "e_planning.php";
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