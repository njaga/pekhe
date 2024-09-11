<?php
session_start();
include_once 'connexion.php';

$id_demande = 15; 





$reponse = $db->prepare("UPDATE `employe` SET nbr_conges=(nbr_conges-(?)) WHERE id=(1215);");
$reponse->execute(array($id_demande)) or die(print_r($reponse->errorInfo()));
