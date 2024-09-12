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
$req = $db->prepare("UPDATE `depense_projet` SET `etat` = '1', date_validation=?, id_validation=? WHERE `id` = ?");
$req->execute(array($date, $_SESSION['id_vigilus_user'], $id));
$nbr = $req->rowCount();
if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
}

?>