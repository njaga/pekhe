<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$date_dotation = htmlspecialchars($_POST['date_dotation']);
$tonfa = htmlspecialchars($_POST['tonfa']);
$ceinturon = htmlspecialchars($_POST['ceinturon']);
$site = htmlspecialchars($_POST['site']);
$registre = htmlspecialchars($_POST['registre']);
$arme = htmlspecialchars($_POST['arme']);
$chargeur_arme = htmlspecialchars($_POST['chargeur_arme']);
$casque = htmlspecialchars($_POST['casque']);
$smartphone = htmlspecialchars($_POST['smartphone']);
$telephone_simple = htmlspecialchars($_POST['telephone_simple']);
$miroir_telescopique = htmlspecialchars($_POST['miroir_telescopique']);
$detecteur = htmlspecialchars($_POST['detecteur']);
$chargeur_detecteur = htmlspecialchars($_POST['chargeur_detecteur']);
$gilet = htmlspecialchars($_POST['gilet']);
$torche = htmlspecialchars($_POST['torche']);



$reponse = $db->prepare("INSERT INTO`dotation_art_site`(`date_dotation`, `site`, `ceinturon`, `tonfa`, `registre`, `arme`, `chargeur_arme`, `casque`, `smartphone`, `telephone_simple`, `miroir_telescopique`, `detecteur`, `chargeur_detecteur`, `gilet`, torche, `id_user`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_dotation, $site, $ceinturon, $tonfa, $registre, $arme, $chargeur_arme, $casque, $smartphone, $telephone_simple, $miroir_telescopique, $detecteur, $chargeur_detecteur, $gilet, $torche,  $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Tonfa' ");
$reponse->execute(array($tonfa)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Ceinturon' ");
$reponse->execute(array($ceinturon)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Registre' ");
$reponse->execute(array($registre)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Arme' ");
$reponse->execute(array($arme)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Chargeur arme' ");
$reponse->execute(array($chargeur_arme)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Casque' ");
$reponse->execute(array($casque)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Smartphone' ");
$reponse->execute(array($smartphone)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Telephone simple' ");
$reponse->execute(array($telephone_simple)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Miroir Telescopique' ");
$reponse->execute(array($miroir_telescopique)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Detecteur' ");
$reponse->execute(array($detecteur)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Chargeur Detecteur' ");
$reponse->execute(array($chargeur_detecteur)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Gilet Fluorescent' ");
$reponse->execute(array($gilet)) or die(print_r($reponse->errorInfo()));



if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "l_dotation_site.php";
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