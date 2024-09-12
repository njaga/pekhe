<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_debut=htmlspecialchars($_POST['date_debut']);
$note=htmlspecialchars(suppr_accents($_POST['note']));
$id_employe=htmlspecialchars($_POST['id_employe']);
$id_site=htmlspecialchars($_POST['site']);
$equipe=htmlspecialchars($_POST['equipe']);
$ancien_id=htmlspecialchars($_POST['ancien_id']);
$montant=htmlspecialchars($_POST['montant']);

//enregistrement de la nouvelle affectation
$reponse=$db->prepare("INSERT INTO `affectation_site`(`equipe`, montant, `date_debut`, `note`, `id_employe`, `id_site`, `id_user`) VALUES (?,?,?,?,?,?,?)");
$reponse->execute(array($equipe, $montant, $date_debut, $note, $id_employe, $id_site, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();

//suppresion de l'ancienne affectation affectation
$reponse=$db->prepare("UPDATE `affectation_site` SET etat=0, date_fin=? WHERE id=?");
$reponse->execute(array($date_debut, $ancien_id)) or die(print_r($reponse->errorInfo()));


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
		alert("Affectation enregistrée");
        window.location="l_affectation_site.php";
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : affectation non enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
?>