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
if ($searchValue != '') {
	$searchQuery = " AND (employe.prenom LIKE :prenom OR employe.nom LIKE :nom )";
	$searchArray = array(
		'prenom' => "%$searchValue%",
		'nom' => "%$searchValue%"
	);
}


## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `sanction_employe` 
INNER JOIN employe ON sanction_employe.id_employe=employe.id
WHERE sanction_employe.etat=1 AND month(sanction_employe.date_sanction)=" . $mois . " AND YEAR(sanction_employe.date_sanction)=" . $annee . "");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `sanction_employe` 
INNER JOIN employe ON sanction_employe.id_employe=employe.id
WHERE sanction_employe.etat=1 AND month(sanction_employe.date_sanction)=" . $mois . " AND YEAR(sanction_employe.date_sanction)=" . $annee . " " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT sanction_employe.id, CONCAT(DATE_FORMAT(sanction_employe.date_sanction, '%d'), '/', DATE_FORMAT(sanction_employe.date_sanction, '%m'),'/', DATE_FORMAT(sanction_employe.date_sanction, '%Y')) AS date_sanction, sanction, motif_sanction, sanction_employe.pj, CONCAT(employe.prenom,' ',employe.nom) As employe, montant
FROM `sanction_employe` 
INNER JOIN employe ON sanction_employe.id_employe=employe.id
WHERE sanction_employe.etat=1 AND month(sanction_employe.date_sanction)=" . $mois . " AND YEAR(sanction_employe.date_sanction)=" . $annee . " " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key => $search) {
	$stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
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
