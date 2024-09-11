<?php
session_start();
include "connexion.php";


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
	$searchQuery=" AND (employe.prenom LIKE :prenom OR employe.nom LIKE :nom OR employe.matricule LIKE :matricule OR employe.adresse LIKE :adresse)";
	$searchArray = array(
		'prenom'=>"%$searchValue%", 
		'nom'=>"%$searchValue%", 
		'matricule'=>"%$searchValue%", 
		'adresse'=>"%$searchValue%" 
	);
}

## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id 
WHERE employe.etat=0 ");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id 
WHERE employe.etat=0 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT employe.id, `matricule`, `prenom`, employe.nom AS nom_employe, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y')) AS date_naissance, `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')) AS date_debut, `note`, `nbr_enfants`, departement.nom AS departement, `fonction`, CONCAT(DATE_FORMAT(employe.date_arret, '%d'), '/', DATE_FORMAT(employe.date_arret, '%m'),'/', DATE_FORMAT(employe.date_arret, '%Y')) AS date_arret, employe.motif_arret, employe.commentaire
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE employe.etat=0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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