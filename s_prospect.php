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
$req=$db->prepare("UPDATE `prospect` SET `etat` = '0' WHERE `prospect`.`id` = ?");
$req->execute(array($id));
$nbr=$req->rowCount();
if($nbr>0)
{
?>
<script type="text/javascript">
    window.history.go(-1);
</script>
<?php
}

?>