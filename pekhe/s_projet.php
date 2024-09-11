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
$date_fin=date('Y-m-d');
$id= intval(htmlspecialchars($_GET['s']));
$req=$db->prepare("UPDATE `projet` SET `etat` = '0', date_fin=? WHERE `id` = ?");
$req->execute(array($date_fin, $id));

$req_depense=$db->prepare("UPDATE `depense_projet` SET `etat`=0 WHERE id_projet=?");
$req_depense->execute(array($id));
$nbr=$req->rowCount();
if($nbr>0)
{
?>
<script type="text/javascript">
    alert("Projet supprimé ! ");
    window.history.go(-1);
</script>
<?php
}

?>