<?php
session_start();
include 'connexion.php';

$id=htmlspecialchars($_POST['id']);
$designation=htmlspecialchars($_POST['designation']);
$pu=htmlspecialchars($_POST['pu']);

$reponse=$db->prepare("UPDATE `article_four` SET `designation`=?, `pu`=? WHERE id=?");
$reponse->execute(array($designation, $pu, $id)) or die(print_r($reponse->errorInfo()));
$nbr=1;


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
		alert("Article modifé");
        window.history.go(-2);
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : article non modifié");
        window.history.go(-1);
    </script>
    <?php
}
?>