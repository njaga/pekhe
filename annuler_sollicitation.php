<?php
session_start();
include 'connexion.php';
$id = htmlspecialchars($_GET['id']);
$commentaire = htmlspecialchars($_POST['commentaire']);
$date_recup = date('Y') . '-' . date('m') . '-' . date('d');

$req = $db->prepare("UPDATE `sollicitation` SET etat=-1, id_commercial=?, date_recup=?, commentaire_resultat=? WHERE id=?");
$result = $req->execute(array($_SESSION['id_vigilus_user'], $date_recup, $commentaire, $id)) or die(print_r($req->errorInfo()));
$nbr = $req->rowCount();

if ($nbr > 0) {
    //echo $verif;
?>
    <script type="text/javascript">
        window.location = "l_sollicitation_cours.php";
    </script>
<?php

} else {
    //echo $verif;            
?>
    <script type="text/javascript">
        alert("Erreur non enregistré");
        window.history.go(-1);
    </script>
<?php
}

?>