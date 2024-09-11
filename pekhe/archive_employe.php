<?php
session_start();
if (!isset($_SESSION['id_vigilus_user'])) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}
include 'connexion.php';

$date_arret = htmlspecialchars($_POST['date_arret']);
$motif = htmlspecialchars($_POST['motif']);
$commentaire = htmlspecialchars($_POST['commentaire']);
$id = intval(htmlspecialchars($_GET['id']));
$req = $db->prepare("UPDATE `employe` SET `etat` = '0', date_arret=?, motif_arret=?, commentaire=? WHERE `employe`.`id` = ?");
$req->execute(array($date_arret, $motif, $commentaire, $id));

$req_update = $db->prepare('UPDATE planning_agent SET etat=0, date_fin=?  WHERE id_agent=? AND etat=1');
$req_update->execute(array($date_arret, $id));

$nbr = $req->rowCount();
if ($nbr > 0) {
?>
    <script type="text/javascript">
        alert("Employé archivé ! ");
        window.history.go(-1);
    </script>
<?php
}

?>