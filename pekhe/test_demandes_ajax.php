<?php
session_start();
include "connexion.php";

$annee = $_POST['annee'];
$mois = $_POST['mois'];

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();
$searchQuery = " ";
if($searchValue!='')
{
	$searchQuery=" AND (employe.prenom LIKE :prenom OR employe.nom LIKE :nom )";
	$searchArray = array(
		'prenom'=>"%$searchValue%", 
		'nom'=>"%$searchValue%" 
	);
}


## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `demande_conges` 
    INNER JOIN employe ON employe.id=demande_conges.id_employe
    INNER JOIN departement ON departement.id=employe.id_departement
    INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
WHERE month(demande_conges.date_debut)=".$mois." AND YEAR(demande_conges.date_debut)=".$annee."");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `demande_conges` 
    INNER JOIN employe ON employe.id=demande_conges.id_employe
    INNER JOIN departement ON departement.id=employe.id_departement
    INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
WHERE month(demande_conges.date_debut)=".$mois." AND YEAR(demande_conges.date_debut)=".$annee." ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT demande_conges.`id`,  CONCAT(DATE_FORMAT(
    demande_conges.`date_debut`, '%d'), '/', DATE_FORMAT(demande_conges.`date_debut`, '%m'),'/', DATE_FORMAT(demande_conges.`date_debut`, '%Y')) AS date_debut,  CONCAT(DATE_FORMAT(demande_conges.`date_fin`, '%d'), '/', DATE_FORMAT(demande_conges.`date_fin`, '%m'),'/', DATE_FORMAT(demande_conges.`date_fin`, '%Y')) AS date_fin, `nbr_jour`, demande_conges.`motif`, demande_conges.`statut`, type_conges.type_conges, CONCAT(DATE_FORMAT(demande_conges.`date_enregistrement`, '%d'), '/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%m'),'/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%Y')) AS date_enregistrement, demande_conges.etat, CONCAT (employe.prenom,' ', employe.nom) AS employe, departement.nom as departement,  demande_conges.commentaire_sup, demande_conges.commentaire_rh
    FROM `demande_conges` 
    INNER JOIN employe ON employe.id=demande_conges.id_employe
    INNER JOIN departement ON departement.id=employe.id_departement
    INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
    WHERE demande_conges.etat=3 AND month(demande_conges.date_debut)=".$mois." AND YEAR(demande_conges.date_debut)=".$annee." ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

// Bind values
foreach($searchArray as $key=>$search){
	$stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

## Response
$response = array(
	"draw" => intval($draw),
	"iTotalRecords" => $totalRecords,
	"iTotalDisplayRecords" => $totalRecordwithFilter,
	"aaData" => $empRecords
 );
 
 echo json_encode($response);

?>