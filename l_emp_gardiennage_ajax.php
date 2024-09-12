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
if ($searchValue != '') {
	$searchQuery = " AND CONCAT(employe.prenom ,' ', employe.nom, ' ', employe.matricule , ' ', employe.adresse ) LIKE :search";
	$searchArray = array(
		'search' => "%$searchValue%"
	);
}

## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(DISTINCT(employe.id)) AS allcount 
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN contrat_employe ON contrat_employe.id_employe=employe.id
LEFT JOIN planning_agent ON planning_agent.id_agent=employe.id
LEFT JOIN site on site.id=planning_agent.id
WHERE employe.etat=1 AND departement.id=3 ");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(DISTINCT(employe.id)) AS allcount 
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN contrat_employe ON contrat_employe.id_employe=employe.id
LEFT JOIN planning_agent ON planning_agent.id_agent=employe.id
LEFT JOIN site on site.id=planning_agent.id
WHERE employe.etat=1 AND departement.id=3 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT employe.id, `matricule`, `prenom`, employe.nom AS nom_employe, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y'), ' à ',`lieu_naissance`) AS date_naissance,  `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')) AS date_debut, employe.`note`, `nbr_enfants`, `fonction`,  employe.telephone, contrat_employe.montant, COALESCE(site.nom, 'Aucun') as nom_site, contrat_employe.type_contrat,CONCAT(DATE_FORMAT(contrat_employe.date_debut, '%d'), '/', DATE_FORMAT(contrat_employe.date_debut, '%m'),'/', DATE_FORMAT(contrat_employe.date_debut, '%Y')) AS date_debut
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN contrat_employe ON contrat_employe.id_employe=employe.id
LEFT JOIN planning_agent ON planning_agent.id_agent=employe.id
LEFT JOIN site on site.id=planning_agent.id
WHERE employe.etat=1 AND departement.id=3 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
