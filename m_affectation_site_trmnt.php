<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_debut=htmlspecialchars($_POST['date_debut']);
$note=htmlspecialchars(suppr_accents($_POST['note']));
$id_site=htmlspecialchars($_POST['site']);
$montant=htmlspecialchars($_POST['montant']);
$equipe=htmlspecialchars($_POST['equipe']);
$id=htmlspecialchars($_POST['id']);

//enregistrement de la nouvelle affectation
$reponse=$db->prepare("UPDATE `affectation_site` SET `equipe`=?, montant=?, `date_debut`=?, `note`=?, `id_site`=?, `id_user`=? WHERE id=?");
$reponse->execute(array($equipe, $montant, $date_debut, $note, $id_site, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));
$nbr=1;


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
		alert("Affectation modifiée");
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