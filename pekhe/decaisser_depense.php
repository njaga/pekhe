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

$id = intval(htmlspecialchars($_GET['id']));
$date = date('Y') . '-' . date('m') . '-' . date('d');

$reponse = $db->query("SELECT `description`, `departement`, `montant` FROM `depense_projet` WHERE id=" . $id);
$donnees = $reponse->fetch();
$description = $donnees['0'];
$departement = $donnees['1'];
$montant = $donnees['2'];

//$req_caisse = $db->prepare('INSERT INTO `caisse`(`date_operation`, `type`, `section`, `motif`, `montant`, `id_user`) VALUES (?,?,?,?,?,?)');
//$req_caisse->execute(array($));
$req = $db->prepare("UPDATE `depense_projet` SET `etat` = '2', id_validation=? WHERE `id` = ?");
$req->execute(array($date, $id));
$nbr = $req->rowCount();
if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
}

?>