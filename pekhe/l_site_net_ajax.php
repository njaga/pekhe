<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
if ($search == "") {
    $reponse = $db->query("SELECT `id`, `nom`, `localisation`, `montant_paiement`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), date_debut
    FROM `site` 
    WHERE etat=1 AND id_departement=5
    ORDER BY nom DESC");
} else {
    $reponse = $db->prepare("SELECT `id`, `nom`, `localisation`, `montant_paiement`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), date_debut
    FROM `site` 
    WHERE CONCAT (nom,' ',localisation) like CONCAT('%', ?, '%') AND etat=1 AND id_departement=5
    ORDER BY nom DESC");
    $reponse->execute(array($search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $nom = $donnees['1'];
    $localisation = $donnees['2'];
    $montant_paiement = $donnees['3'];
    $date_debut = $donnees['4'];
    $date_debut_n = $donnees['5'];
    //Agents travaillents sur site
    $req_emp = $db->prepare("SELECT employe.prenom, employe.nom 
	FROM `planning_agent` 
	INNER JOIN employe ON employe.id=planning_agent.id_agent
	WHERE planning_agent.id_site=? AND planning_agent.etat=1");
    $req_emp->execute(array($id));
    $nbr_emp = 0;
    $employes = "";
    while ($donnees_emp = $req_emp->fetch()) {
        $employes = $employes . " " . $donnees_emp['0'] . " " . $donnees_emp['1'] . "<br>";
        $nbr_emp = $nbr_emp + 1;
    }

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $nom . "</td>";
    echo "<td class='text-center'>" . $localisation . "</td>";
    echo "<td class='text-center'>" . $date_debut . "</td>";
    echo '<td class="text-center"><a href="planning_detail.php?s=' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Détails">' . str_pad($nbr_emp, 2, "0", STR_PAD_LEFT) . '</a></td>';
    echo '<td class="text-center"><a href="planning_detail.php?s=' . $id . '" class="blue btn" data-toggle="tooltip" data-placement="top" title="Détails">Afficher plannig</a></td>';

    $i++;

?>

<?php
    echo "</tr>";
}

?>
<script type="text/javascript">
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>