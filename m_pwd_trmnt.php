<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$reponse=$db->prepare("SELECT pwd FROM `user` WHERE id=?");
$reponse->execute(array($_SESSION['id_vigilus_user']));
$donnee=$reponse->fetch();
$pwd=$donnee['0'];

$ancien_password=sha1(htmlspecialchars($_POST['ancien_password']));
$new_password=sha1(htmlspecialchars($_POST['new_password']));
$confirm_password=sha1(htmlspecialchars($_POST['confirm_password']));

if($pwd!=$ancien_password)
{
    ?>
    <script type="text/javascript">
        alert("Erreur : Ancien mot de passe incorrecte");
        window.history.go(-1);
    </script>
    <?php
}
elseif($new_password!=$confirm_password)
{
    ?>
    <script type="text/javascript">
        alert("Erreur : les nouveaux mot de passe ne correspondent pas");
        window.history.go(-1);
    </script>
    <?php
}
else
{
    $reponse=$db->prepare("UPDATE user SET pwd=? WHERE id=?");
    $reponse->execute(array($new_password, $_SESSION['id_vigilus_user']));
    ?>
    <script type="text/javascript">
        alert("Mot de passe modifiée");
        window.location="accueil.php";
    </script>
    <?php
}

