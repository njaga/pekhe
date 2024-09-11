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
	$searchQuery=" AND (article.ref LIKE :ref OR article.designation LIKE :designation OR article.marque LIKE :marque OR article.modele LIKE :modele)";
	$searchArray = array(
		'ref'=>"%$searchValue%", 
		'designation'=>"%$searchValue%", 
		'marque'=>"%$searchValue%", 
		'modele'=>"%$searchValue%" 
	);
}

## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `article` 
INNER JOIN categorie ON article.id_categorie = categorie.id 
WHERE article.etat=1 ");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `article` 
INNER JOIN categorie ON article.id_categorie = categorie.id 
WHERE article.etat=1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT article.id, article.ref, article.designation, article.marque, article.modele, article.pu, article.qt, categorie.categorie, (article.pu*article.qt) as prix
FROM `article` 
INNER JOIN categorie ON article.id_categorie = categorie.id 
WHERE article.etat=1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
