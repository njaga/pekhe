<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$nom = htmlspecialchars(suppr_accents($_POST['nom']));
$localisation = htmlspecialchars(suppr_accents($_POST['localisation']));
$date_debut = htmlspecialchars(suppr_accents($_POST['date_debut']));
$departement = htmlspecialchars(suppr_accents($_POST['departement']));
$id = htmlspecialchars(suppr_accents($_POST['id']));

$reponse = $db->prepare("UPDATE `site` SET `nom`=?, `localisation`=?, `date_debut`=?, `id_departement`=?, `id_user`=? WHERE id=?");
$reponse->execute(array($nom, $localisation, $date_debut, $departement, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

?>
<script type="text/javascript">
    alert("Site modifié");
    window.history.go(-1);
</script>
<?php
?>