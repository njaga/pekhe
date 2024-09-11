<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id=htmlspecialchars($_POST['id']);
$employe_remplacant="";
$employe_remplace="";
$motif_absence="";
$motif_hs="";
$motif_absence=htmlspecialchars($_POST['motif_absence']);
$motif_hs=htmlspecialchars($_POST['motif_hs']);

$date_absence=htmlspecialchars($_POST['date_remplacement']);
$id_site=htmlspecialchars($_POST['site']);
if(isset($_POST['employe_remplace']))
{
    $employe_remplace=htmlspecialchars($_POST['employe_remplace']);
    $montant_retirer=htmlspecialchars($_POST['montant_retirer']);
}
if(isset($_POST['employe_remplacant']))
{
    $employe_remplacant=htmlspecialchars($_POST['employe_remplacant']);
    $montant_heure_sup=htmlspecialchars($_POST['montant_heure_sup']);
}
$motif=htmlspecialchars($_POST['motif']);

if($employe_remplacant=="")
{
    $employe_remplacant=NULL;
    $montant_heure_sup=0;
}
if($employe_remplace=="")
{
    $employe_remplace=NULL;
    $montant_retirer=0;
}
/*
    $reponse=$db->prepare("UPDATE `absence_remplacement` SET `id_site`=?, `id_employe_remplace`=?, `montant_retirer`=?, `date_absence`=?, `motif`=?, `id_user`=? WHERE id=?");
    $reponse->execute(array($id_site, $employe_remplace, $montant_retirer, $date_absence, $motif, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));
}
elseif($employe_remplace==""){
    $reponse=$db->prepare("UPDATE `absence_remplacement` SET `id_site`=?, `id_employe_remplacant`=?, `montant_heure_sup`=?, `date_absence`=?, `motif`=?, `id_user`=? WHERE id=?");
    $reponse->execute(array($id_site, $employe_remplacant, $montant_heure_sup, $date_absence, $motif, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));
}
else{
}
*/
$reponse=$db->prepare("UPDATE `absence_remplacement` SET `id_site`=?, `id_employe_remplace`=?, `montant_retirer`=?, `id_employe_remplacant`=?, `montant_heure_sup`=?, `date_absence`=?, `motif`=?, `motif_hs`=?,`motif_absence`=?, `id_user`=? WHERE id=?");
$reponse->execute(array($id_site, $employe_remplace, $montant_retirer, $employe_remplacant, $montant_heure_sup, $date_absence, $motif, $motif_hs, $motif_absence, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));



$nbr=1;


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
		//alert("Opération enregistrée");
        window.location="l_abs_remp.php";
        //window.location="e_abs_remp.php";
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : opération non enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
?>