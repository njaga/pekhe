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
$id= intval(htmlspecialchars($_GET['id']));
$req=$db->prepare("UPDATE `projet` SET `etat` = '2', date_fin=? WHERE `id` = ?");
$req->execute(array($date_fin, $id));
$nbr=$req->rowCount();
if($nbr>0)
{
?>
<script type="text/javascript">
    alert("Projet clôturé ! ");
    window.history.go(-2);
</script>
<?php
}

?>