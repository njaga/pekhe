<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_operation = htmlspecialchars($_POST['date_operation']);
$type_operation = htmlspecialchars($_POST['type_operation']);
$section = htmlspecialchars($_POST['section']);
$description = htmlspecialchars($_POST['description']);
//$bon = htmlspecialchars($_POST['bon']);
//$carnet = htmlspecialchars($_POST['carnet']);
$montant = htmlspecialchars($_POST['montant']);
$num_cheque = htmlspecialchars($_POST['num_cheque']);
$compte = htmlspecialchars($_POST['compte']);

$reponse = $db->prepare("INSERT INTO `banque`(`date_operation`, `type`, `section`, `motif`, `montant`, num_cheque, compte, id_user) VALUES (?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_operation, $type_operation, $section, $description, $montant, $num_cheque, $compte, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

$id_banque = $db->lastInsertId();


//Insertion des docs du projet 
switch ($_FILES["bc"]['error']) {
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
            $extension = strtolower(strrchr($_FILES["bc"]['name'], '.'));
            $extensions_autorisees = array('.pdf', '.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees)) {
                $error = 'Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            } else {
                $repertoire = $_SESSION['chemin_document'] . 'banque/' . $id_banque . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }

                $nom_document = "PJ";
                move_uploaded_file($_FILES["bc"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc_caisse = $repertoire . $nom_document . $extension;

                $req_document = $db->prepare("INSERT INTO document_caisse (`type_document`, `nom_document`, `chemin`, `id_banque`,  id_user) VALUES (?,?,?,?,?)");
                $req_document->execute((array("PJ", "PJ", $doc_caisse, $id_banque,  $_SESSION['id_vigilus_user'])));
            }
        }
}

if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : Opération non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>