<?php
session_start();
include "connexion.php";

$annee = $_POST['annee'];
$mois = $_POST['mois'];

if($mois==1)
{
	$date_debut="'".($annee-1)."-12-26'";
	$date_fin="'".$annee."-".$mois."-25'";
}
else
{
	$date_debut="'".$annee."-".($mois-1)."-26'";
	$date_fin="'".$annee."-".($mois)."-25'";
}


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
	$searchQuery=" AND CONCAT(remplace.prenom,' ', remplace.nom) like CONCAT('%', :remplace, '%') OR CONCAT(remplacant.prenom ,' ', remplacant.nom) like CONCAT('%', :remplacant, '%') OR CONCAT(site.nom) like CONCAT('%', :site, '%')";
	$searchArray = array(
		'remplace'=>"%$searchValue%",
		'site'=>"%$searchValue%",
		'remplacant'=>"%$searchValue%"

	);
}


## Total number of records without filtering
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `absence_remplacement` 
INNER JOIN site ON absence_remplacement.id_site=site.id 
WHERE date_absence BETWEEN ".$date_debut." AND ".$date_fin);
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `absence_remplacement` 
INNER JOIN site ON absence_remplacement.id_site=site.id
LEFT JOIN employe as remplacant ON absence_remplacement.id_employe_remplacant=remplacant.id
LEFT JOIN employe as remplace ON absence_remplacement.id_employe_remplace=remplace.id
WHERE date_absence BETWEEN ".$date_debut." AND ".$date_fin." ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT absence_remplacement.id, CONCAT(remplace.prenom,' ',remplace.nom) AS emp_remplace, CONCAT(remplacant.prenom,' ',remplacant.nom) AS emp_remplacant, CONCAT(DATE_FORMAT(`date_absence`, '%d'), '/', DATE_FORMAT(`date_absence`, '%m'),'/', DATE_FORMAT(`date_absence`, '%Y')) AS date, site.nom AS site, montant_retirer, montant_heure_sup, motif, motif_absence, motif_hs
FROM `absence_remplacement` 
INNER JOIN site ON absence_remplacement.id_site=site.id
LEFT JOIN employe as remplacant ON absence_remplacement.id_employe_remplacant=remplacant.id
LEFT JOIN employe as remplace ON absence_remplacement.id_employe_remplace=remplace.id
WHERE date_absence BETWEEN ".$date_debut." AND ".$date_fin." ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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