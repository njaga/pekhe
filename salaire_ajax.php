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
$stmt = $db->query("SELECT COUNT(*) AS allcount 
FROM `employe` 
WHERE employe.etat=1  ");
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount 
FROM `employe` 
WHERE employe.etat=1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT  employe.id as employe_id, `matricule`, `prenom`, employe.nom AS nom_employe, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y'), ' à ',`lieu_naissance`) AS date_naissance,  `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')) AS date_debut, employe.`note`, `nbr_enfants`, `fonction`,  employe.telephone, 
(SELECT contrat_employe.montant FROM `contrat_employe` WHERE etat=1 AND id_employe=employe_id) as salaire,
(SELECT contrat_employe.type_contrat  FROM `contrat_employe` WHERE etat=1 AND id_employe=employe_id) as type_contrat,
(SELECT CONCAT(DATE_FORMAT(contrat_employe.date_debut, '%d'), '/', DATE_FORMAT(contrat_employe.date_debut, '%m'),'/', DATE_FORMAT(contrat_employe.date_debut, '%Y'))  FROM `contrat_employe` WHERE etat=1 AND id_employe=employe_id) as date_debut_contrat,
(SELECT site.nom FROM `employe` INNER JOIN planning_agent ON planning_agent.id_agent=employe.id INNER JOIN site on site.id=planning_agent.id_site WHERE employe.id=employe_id AND planning_agent.etat=1) as site,
(SELECT COALESCE(SUM(absence_remplacement.montant_retirer), '0')
FROM absence_remplacement
WHERE absence_remplacement.id_employe_remplace=employe_id AND date_absence BETWEEN '2023-01-26' AND '2023-02-25') as abs, 
(SELECT COALESCE(SUM(absence_remplacement.montant_heure_sup), '0')
FROM absence_remplacement
WHERE absence_remplacement.id_employe_remplacant=employe_id AND date_absence BETWEEN '2023-01-26' AND '2023-02-25') as hs, employe.prime,
(employe.prime + (SELECT contrat_employe.montant FROM `contrat_employe` WHERE etat=1 AND id_employe=employe_id) + (SELECT COALESCE(SUM(absence_remplacement.montant_heure_sup), '0')
FROM absence_remplacement
WHERE absence_remplacement.id_employe_remplacant=employe_id AND date_absence BETWEEN '2023-01-26' AND '2023-02-25') - (SELECT COALESCE(SUM(absence_remplacement.montant_retirer), '0')
FROM absence_remplacement
WHERE absence_remplacement.id_employe_remplace=employe_id AND date_absence BETWEEN '2023-01-26' AND '2023-02-25') ) as net_payer
FROM `employe` 
WHERE employe.etat=1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
