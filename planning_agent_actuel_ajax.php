<?php
session_start();
include 'connexion.php';
$employe = $_POST['employe'];

$reponse = $db->prepare("SELECT site.nom, CONCAT(DATE_FORMAT(planning_agent.date_debut, '%d'), '/', DATE_FORMAT(planning_agent.date_debut, '%m'),'/', DATE_FORMAT(planning_agent.date_debut, '%Y')) 
    FROM `planning_agent`
    INNER JOIN site ON site.id=planning_agent.id_site
    WHERE id_agent=? AND planning_agent.etat=1;");
$reponse->execute(array($employe));
$nbr = $reponse->rowCount();
if ($nbr > 0) {
    $donnees = $reponse->fetch();
    echo "<p>" . $donnees['0'] . " depuis le <b>" . $donnees['1'] . "</b></p>";
} else {
    echo "<p>Aucune planning</p>";
}
