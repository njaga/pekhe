<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id = htmlspecialchars(($_POST['id']));
$date_arret = htmlspecialchars(($_POST['date_arret']));
$observation = htmlspecialchars(($_POST['observation']));

$reponse = $db->prepare("UPDATE `site` SET `etat`=0, date_fin=?, observation=? WHERE id=?");
$reponse->execute(array($date_arret, $observation, $id)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `planning_agent` SET etat=0, date_fin=?, observation=? WHERE id_site=? AND etat=1");
$reponse->execute(array($date_arret, $observation, $id)) or die(print_r($reponse->errorInfo()));
$nbr = 1;


if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : site non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>