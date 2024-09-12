<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id_article=htmlspecialchars($_POST['article']);
$date_sortie=htmlspecialchars($_POST['date_sortie']);
$qt=htmlspecialchars($_POST['qt']);
$commentaire=htmlspecialchars($_POST['commentaire']);
$technicien=htmlspecialchars($_POST['technicien']);

$req_ancien = $db->prepare("SELECT  `qt` FROM `article` WHERE id=?");
$req_ancien->execute(array($id_article));
$donnee = $req_ancien->fetch();
$ancien_qt = $donnee['0'];
$new_qt = $ancien_qt - $qt;

$reponse=$db->prepare("INSERT INTO `sortie_art`(`date_sortie`, `id_article`, `commentaire`, `technicien`, qt, `id_user`) VALUES (?,?,?,?,?,?)");
$reponse->execute(array($date_sortie, $id_article, $commentaire, $technicien, $qt, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();

$req_new = $db->prepare("UPDATE article SET `qt`=? WHERE id= ?");
$req_new->execute(array($new_qt, $id_article));


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : sortie non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>