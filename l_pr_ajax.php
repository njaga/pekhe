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
	$searchQuery=" AND (article_four.designation LIKE :designation)";
	$searchArray = array(
		'designation'=>"%$searchValue%" 
	);
}

## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `article_four` 
INNER JOIN fournisseur_achat ON fournisseur_achat.id=article_four.id_fournisseur
WHERE article_four.etat=1 AND fournisseur_achat.etat=1");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `article_four` 
INNER JOIN fournisseur_achat ON fournisseur_achat.id=article_four.id_fournisseur
WHERE article_four.etat=1 AND fournisseur_achat.etat=1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT `article_four`.`id`, `designation`, `pu`, fournisseur_achat.nom AS fournisseur, `article_four`.`etat` 
FROM `article_four` 
INNER JOIN fournisseur_achat ON fournisseur_achat.id=article_four.id_fournisseur
WHERE article_four.etat=1 AND fournisseur_achat.etat=1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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