<?php
session_start();
include 'connexion.php';

$reponse=$db->query("SELECT employe.id
FROM `user` 
INNER JOIN employe ON employe.id=user.id_employe
INNER JOIN departement on departement.id=employe.id_departement
WHERE user.etat=1");

$ids="";
$i=1;
while ($donnees= $reponse->fetch())
{
	$id=$donnees['0'];
	$ids=$ids.",".$id;
    $req_nbr_jou_conges = $db->query("UPDATE employe SET employe.nbr_conges=employe.nbr_conges+2 WHERE id=
    ".$id);
	
}
$req_ajout_jou_conges = $db->query("INSERT INTO `ajout_jours_conges`(`ids_employes`) VALUES('".$ids."')");
	?>
