<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$id = htmlspecialchars($_GET['id']);




$reponse = $db->prepare("UPDATE `dotation_art_gard` SET `etat`=0 WHERE id=?");
$reponse->execute(array($id)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();
$nbr = 1;

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=1 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=2 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=3 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=4 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=5 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=6 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=7 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=8 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=9 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=10 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=11 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=12 ");

$reponse = $db->query("UPDATE `article_gardiennage` SET `qt`=qt + 1 WHERE id=13 ");




if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "l_dotation.php";
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : opération non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>