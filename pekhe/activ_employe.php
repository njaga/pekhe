<?php
session_start();
if(!isset($_SESSION['id_vigilus_user']))
{
?>
<script type="text/javascript">
    alert("Veillez d'abord vous connectez !");
    window.location = 'index.php';

</script>
<?php
}
include 'connexion.php';

$id= intval(htmlspecialchars($_GET['id']));
$req=$db->prepare("UPDATE `employe` SET `etat` = '1' WHERE `employe`.`id` = ?");
$req->execute(array($id));
$req_affectation=$db->prepare("UPDATE `affectation_site` SET `etat` = '1' WHERE `affectation_site`.`id_employe` = ?");
$req_affectation->execute(array($id));
$nbr=$req->rowCount();
if($nbr>0)
{
?>
<script type="text/javascript">
    alert("Employé rétbalie ! ");
    window.history.go(-1);
</script>
<?php
}

?>