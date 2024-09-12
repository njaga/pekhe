<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$verif = 0;

$date_sanction = htmlspecialchars($_POST['date_sanction']);
$employe = htmlspecialchars($_POST['employe']);
$sanction = htmlspecialchars($_POST['sanction']);
$motif_sanction = htmlspecialchars($_POST['motif_sanction']);
$id_sanction = htmlspecialchars($_POST['id_sanction']);
$montant = htmlspecialchars($_POST['montant']);

$doc = '';
switch ($_FILES["pj"]['error']) {
    case 1: // UPLOAD_ERR_INI_SIZE
        $error = "Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
        break;
    case 2: // UPLOAD_ERR_FORM_SIZE
        $error = "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
        break;
    case 3: // UPLOAD_ERR_PARTIAL
        $error = "L'envoi du fichier a été interrompu pendant le transfert !";
        break;
    case 4: // UPLOAD_ERR_NO_FILE
        $doc = '';
        break;
    default: {
            // Testons si l'extension est autorisée
            $extension = strtolower(strrchr($_FILES["pj"]['name'], '.'));
            $extensions_autorisees = array('.pdf', '.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees)) {
                $error = 'Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            } else {
                $repertoire = $_SESSION['chemin_document'] . 'sanction_employe/' . $id_sanction . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }
                $nom_document = "pj";
                move_uploaded_file($_FILES["pj"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc = $repertoire . $nom_document . $extension;
            }
        }
}
//modification des infos sur le conrole
if ($doc = "") {
    $req = $db->prepare("UPDATE `sanction_employe` SET `date_sanction`=?, `sanction`=?, `motif_sanction`=?, `pj`=?, `id_employe`=?,montant=?, `id_user`=? WHERE id=?");
    $result = $req->execute(array($date_sanction, $sanction, $motif_sanction, $doc, $employe, $montant, $_SESSION['id_vigilus_user'], $id_sanction)) or die(print_r($req->errorInfo()));
} else {
    $req = $db->prepare("UPDATE `sanction_employe` SET `date_sanction`=?, `sanction`=?, `motif_sanction`=?, `id_employe`=?,montant=?, `id_user`=? WHERE id=?");
    $result = $req->execute(array($date_sanction, $sanction, $motif_sanction, $employe, $montant, $_SESSION['id_vigilus_user'], $id_sanction)) or die(print_r($req->errorInfo()));
}
$nbr = 1;

if ($nbr > 0) {
?>
    <script type="text/javascript">
        alert("Sanction modifiée");
        window.location = "l_sanction.php";
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur controle non modifiée");
        window.history.go(-1);
    </script>
<?php
}

?>