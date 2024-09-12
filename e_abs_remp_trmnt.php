<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$employe_remplacant="";
$employe_remplace="";
$motif_absence="";
$motif_hs="";

$date_absence=htmlspecialchars($_POST['date_remplacement']);
$id_site=htmlspecialchars($_POST['site']);
if(isset($_POST['employe_remplace']))
{
    $employe_remplace=htmlspecialchars($_POST['employe_remplace']);
    $montant_retirer=htmlspecialchars($_POST['montant_retirer']);
    $motif_absence=htmlspecialchars($_POST['motif_absence']);
}
if(isset($_POST['employe_remplacant']))
{
    $employe_remplacant=htmlspecialchars($_POST['employe_remplacant']);
    $montant_heure_sup=htmlspecialchars($_POST['montant_heure_sup']);
    $motif_hs=htmlspecialchars($_POST['motif_hs']);
}
$motif=htmlspecialchars($_POST['motif']);
/*
if($employe_remplacant==""){
    $reponse=$db->prepare("INSERT INTO `absence_remplacement`(`id_site`, `id_employe_remplace`, `montant_retirer`, `date_absence`, `motif`, `id_user`) VALUES (?,?,?,?,?,?)");
    $reponse->execute(array($id_site, $employe_remplace, $montant_retirer, $date_absence, $motif, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
}
elseif($employe_remplace==""){
    $reponse=$db->prepare("INSERT INTO `absence_remplacement`(`id_site`, `id_employe_remplacant`, `montant_heure_sup`, `date_absence`, `motif`, `id_user`) VALUES (?,?,?,?,?,?)");
    $reponse->execute(array($id_site, $employe_remplacant, $montant_heure_sup, $date_absence, $motif, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
}
else{
}
*/
if($employe_remplacant=="")
{
    $employe_remplacant=NULL;
    $montant_heure_sup=0;
    $motif_hs="";
}
if($employe_remplace=="")
{
    $employe_remplace=NULL;
    $montant_retirer=0;
    $motif_absence="";
}
$reponse=$db->prepare("INSERT INTO `absence_remplacement`(`id_site`, `id_employe_remplace`, `montant_retirer`, `id_employe_remplacant`, `montant_heure_sup`, `date_absence`, `motif`,motif_absence, motif_hs, `id_user`) VALUES (?,?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($id_site, $employe_remplace, $montant_retirer, $employe_remplacant, $montant_heure_sup, $date_absence, $motif, $motif_absence, $motif_hs, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


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