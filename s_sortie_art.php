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

$req_ancien = $db->prepare("SELECT article.id, article.qt, sortie_art.qt
FROM `sortie_art` 
INNER JOIN article ON article.id=sortie_art.id_article
WHERE sortie_art.id=?");
$req_ancien->execute(array($id));
$donnee=$req_ancien->fetch();
$id_article=$donnee['0'];
$qt_art=$donnee['1'];
$qt_sortie=$donnee['2'];
$new_qt = $qt_art + $qt_sortie;


$req=$db->prepare("UPDATE `article` SET `qt` = ? WHERE `id` = ?");
$req->execute(array($new_qt, $id));
$nbr=$req->rowCount();

$req=$db->prepare("DELETE FROM `sortie_art` WHERE id=? ");
$req->execute(array($id));
if($nbr>0)
{
?>
<script type="text/javascript">
    alert("Suppression résussi ! ");
    window.history.go(-1);
</script>
<?php
}

?>