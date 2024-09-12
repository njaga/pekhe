<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$type_contrat=htmlspecialchars(suppr_accents($_POST['type_contrat']));
$date_debut=htmlspecialchars(suppr_accents($_POST['date_debut']));
$date_prevu_fin=htmlspecialchars(suppr_accents($_POST['date_fin']));
$montant=htmlspecialchars(suppr_accents($_POST['montant']));
$id_contrat=htmlspecialchars(suppr_accents($_POST['id_contrat']));

$req_contrat=$db->prepare('UPDATE `contrat_employe` SET `type_contrat`=?, `date_debut`=?, `date_prevu_fin`=?, `montant`=? WHERE id=?');
$req_contrat->execute(array($type_contrat, $date_debut, $date_prevu_fin, $montant, $id_contrat)) or die(print_r($req_contrat->errorInfo()));;
$nbr=$req_contrat->rowCount();

if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        alert("Contrat modifié");
        window.location="l_emp_contr.php";
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
        alert("Erreur contrat non modifié");
        window.history.go(-1);
    </script>
    <?php
}
    
?>