
<?php
include 'connexion.php';
$list_mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

$mois=$_POST['mois'];
$annee=$_POST['annee'];

if($mois==1)
{
	$date_debut="'".($annee-1)."-12-26'";
	$date_fin="'".$annee."-".$mois."-25'";
}
else
{
	$date_debut="".$annee."-".($mois-1)."-26";
	$date_fin="".$annee."-".($mois)."-25";
}
//$date_debut="2020-12-25";
//$date_fin="2021-01-26";

$db->query("SET lc_time_names = 'fr_FR';");

//requête des nouveaux agents
$req_nouveau_agent=$db->prepare("SELECT employe.prenom, employe.nom, CONCAT(DATE_FORMAT(`date_debut`, '%d'), '/', DATE_FORMAT(`date_debut`, '%m'),'/', DATE_FORMAT(`date_debut`, '%Y')) AS date_debut
FROM `employe` 
WHERE employe.date_debut BETWEEN ? AND ? ORDER BY nom");
$req_nouveau_agent->execute(array($date_debut, $date_fin)) or die(print_r($req_nouveau_agent->errorInfo()));

//requête des qui ont arrêté
$req_agent_arrete=$db->prepare("SELECT employe.prenom, employe.nom, CONCAT(DATE_FORMAT(`date_arret`, '%d'), '/', DATE_FORMAT(`date_arret`, '%m'),'/', DATE_FORMAT(`date_arret`, '%Y')) AS date_arret
FROM `employe` 
WHERE employe.date_arret BETWEEN ? AND ? ORDER BY nom");
$req_agent_arrete->execute(array($date_debut, $date_fin)) or die(print_r($req_nouveau_agent->errorInfo()));

//Liste des employes remplacés et remplaçant
$rep_emp=$db->prepare("SELECT DISTINCT id_employe_remplace AS nbr_emp, CONCAT(employe.prenom,' ',employe.nom), site.nom 
FROM `absence_remplacement`
INNER JOIN employe ON absence_remplacement.id_employe_remplace=employe.id
INNER JOIN affectation_site ON affectation_site.id_employe=employe.id
INNER JOIN site ON affectation_site.id_site=site.id
WHERE date_absence BETWEEN ? AND ? AND id_employe_remplace IS NOT NULL AND affectation_site.etat=1 
UNION
SELECT DISTINCT id_employe_remplacant, CONCAT(employe.prenom,' ',employe.nom), site.nom 
FROM `absence_remplacement`
INNER JOIN employe ON absence_remplacement.id_employe_remplacant=employe.id
INNER JOIN affectation_site ON affectation_site.id_employe=employe.id
INNER JOIN site ON affectation_site.id_site=site.id
WHERE date_absence BETWEEN ? AND ? AND id_employe_remplacant IS NOT NULL AND affectation_site.etat=1  
ORDER BY `nbr_emp` ASC");
$rep_emp->execute(array($date_debut, $date_fin, $date_debut, $date_fin));


require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$phpExcel = new Spreadsheet();
$phpExcel->getProperties()->setCreator('Vigilus')
         ->setTitle('Rapport du mois de '.$list_mois[$mois].'.xlsx')
         ->setSubject('Rapport du mois de '.$list_mois[$mois].'.xlsx')
         ->setDescription('Rapport du mois de '.$list_mois[$mois].'.xlsx');

$phpExcel->getActiveSheet()->setTitle('Rapport du mois de '.$list_mois[$mois]);
$phpExcel->setActiveSheetIndex(0)
         ->setCellValue('A1','Employés')
         ->setCellValue('B1','Sites')
        ->setCellValue('C1','Heures Supp')
        ->setCellValue('D1','Absences')
        ->setCellValue('E1','Accomptes');

$i=2;

    $total_hs=0;
    $total_retirer=0;
    $total_accompte=0;
    while ($donnees_emp= $rep_emp->fetch())
    {

        $id_employe=$donnees_emp['0'];
        $employe=$donnees_emp['1'];
        $site=$donnees_emp['2'];

        //montant retenu
        $req_retirer=$db->prepare("SELECT COALESCE(SUM(absence_remplacement.montant_retirer), '0')
        FROM absence_remplacement
        WHERE absence_remplacement.id_employe_remplace=? AND date_absence BETWEEN ? AND ?");
        $req_retirer->execute(array($id_employe, $date_debut, $date_fin));
        $donnees_retirer=$req_retirer->fetch();
        $montant_retirer=$donnees_retirer['0'];

        //montant hs
        $req_hs=$db->prepare("SELECT COALESCE(SUM(absence_remplacement.montant_heure_sup), '0')
        FROM absence_remplacement
        WHERE absence_remplacement.id_employe_remplacant=? AND date_absence BETWEEN ? AND ?");
        $req_hs->execute(array($id_employe, $date_debut, $date_fin));
        $donnees_hs=$req_hs->fetch();
        $montant_hs=$donnees_hs['0'];

        //Accomptes
        $req_accompte=$db->prepare("SELECT montant 
        FROM `accompte` 
        WHERE id_employe=? AND mois=?");
        $req_accompte->execute(array($id_employe, $mois));
        $donnees_accompte=$req_accompte->fetch();
        $montant_accompte=$donnees_accompte['0'];

        $phpExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $employe)
                    ->setCellValue('B'.$i, $site)
                    ->setCellValue('C'.$i, $montant_hs)
                    ->setCellValue('D'.$i, $montant_retirer) 
                    ->setCellValue('E'.$i, $montant_accompte); 

       $total_hs = $total_hs + $montant_hs; 
       $total_retirer = $total_retirer + $montant_retirer; 
       $total_accompte = $total_accompte + $montant_accompte; 
       $i++;
    }

    $phpExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, '')
                ->setCellValue('B'.$i, 'TOTAL')
                ->setCellValue('C'.$i, $total_hs)
                ->setCellValue('D'.$i, $total_retirer)
                ->setCellValue('E'.$i, $total_accompte);	
$i++;
$i++;
//Affiche desnouveaux employés
$phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'Nouveaux Agent(s)');
$i++;
$phpExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, 'Prénom')
        ->setCellValue('B'.$i, 'Nom')
        ->setCellValue('C'.$i, 'Date début');
$i++;
while ($donnees_nouveau_agent= $req_nouveau_agent->fetch())
{
    $prenom=$donnees_nouveau_agent['0'];
    $nom=$donnees_nouveau_agent['1'];
    $date_arret=$donnees_nouveau_agent['2'];
    $phpExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $prenom)
        ->setCellValue('B'.$i, $nom)
        ->setCellValue('C'.$i, $date_arret);
    $i++;
}

$i++;
$i++;
//Affiche des employés qui ont arrêtés
$phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'Agent(s) qui ont arrêté');
$i++;
$phpExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, 'Prénom')
        ->setCellValue('B'.$i, 'Nom')
        ->setCellValue('C'.$i, 'Date arrêt');
$i++;
while ($donnees_agent_arret= $req_agent_arrete->fetch())
{
    $prenom=$donnees_agent_arret['0'];
    $nom=$donnees_agent_arret['1'];
    $date_arret=$donnees_agent_arret['2'];
    $phpExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $prenom)
        ->setCellValue('B'.$i, $nom)
        ->setCellValue('C'.$i, $date_arret);
    $i++;
}

$writer = new Xlsx($phpExcel);

$filename = 'Rapport du mois de '.$list_mois[$mois].'.xlsx';
$writer->save($filename);
header('Content-disposition: attachment; filename='.$filename);
header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($filename));
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush(); 

readfile($filename);
unlink($filename);