<?php
session_start();
include "connexion.php";


$id = $_POST['id'];
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
	$searchQuery = " AND (depense_projet.description LIKE :description_projet)";
	$searchArray = array(
		'description_projet' => "%$searchValue%"
	);
}

## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `depense_projet` 
WHERE depense_projet.etat=1 AND depense_projet.id_projet=" . $id);
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `depense_projet` 
WHERE depense_projet.etat>=0 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT id, CONCAT(DATE_FORMAT(`date_ajout`, '%d'), '/', DATE_FORMAT(`date_ajout`, '%m'),'/', DATE_FORMAT(`date_ajout`, '%Y')) AS date_depense, description, qt, montant, fournisseur, depense_projet.etat, departement, priorite 
FROM `depense_projet` 
WHERE depense_projet.etat>=0 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
