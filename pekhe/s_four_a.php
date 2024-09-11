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
$req=$db->prepare("UPDATE `fournisseur_achat` SET `etat` = '0', date_suppression=? WHERE `id` = ?");
$req->execute(array($date_fin, $id));

$req_depense=$db->prepare("UPDATE `article_four` SET `etat`=0 WHERE id_fournisseur=?");
$req_depense->execute(array($id));
$nbr=$req->rowCount();
if($nbr>0)
{
?>
<script type="text/javascript">
    alert("Fournisseur supprimé ! ");
    window.history.go(-1);
</script>
<?php
}

?>