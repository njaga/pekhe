<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_visite=htmlspecialchars($_POST['date_visite']);
$heure_visite=htmlspecialchars($_POST['heure_visite']);
$personne_demandee=htmlspecialchars($_POST['personne_demandee']);
$motif_visit=htmlspecialchars($_POST['motif']);
$visiteur=htmlspecialchars($_POST['visiteur']);


$reponse=$db->prepare("INSERT INTO  `visiteur`(`date_visite`, `visiteur`, `heure_visite`, `personne_demandee`, `motif_visit`,  `id_user`) VALUES (?,?,?,?,?,?)");
$reponse->execute(array($date_visite, $visiteur, $heure_visite, $personne_demandee,$motif_visit, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : visiteur non enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
?>