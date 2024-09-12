<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id = htmlspecialchars($_POST['id']);
$date_operation = htmlspecialchars($_POST['date_operation']);
$type_operation = htmlspecialchars($_POST['type_operation']);
$section = htmlspecialchars($_POST['section']);
$description = htmlspecialchars($_POST['description']);
$montant = htmlspecialchars($_POST['montant']);

$reponse = $db->prepare("UPDATE `caisse` SET `date_operation`=?, `type`=?, `section`=?,  `motif`=?, `montant`=? WHERE id=?");
$reponse->execute(array($date_operation, $type_operation, $section, $description, $montant, $id)) or die(print_r($reponse->errorInfo()));
$nbr = 1;

if (isset($_POST['bc'])) {
    $bc = htmlspecialchars($_POST['bc']);
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
                    $repertoire = $_SESSION['chemin_document'] . 'caisse/' . $id_caisse . '/';
                    if (is_dir($repertoire)) {
                    } else {
                        mkdir($repertoire);
                    }

                    $nom_document = "PJ";
                    move_uploaded_file($_FILES["bc"]['tmp_name'], $repertoire . $nom_document . $extension);
                    $doc_caisse = $repertoire . $nom_document . $extension;

                    $req_document = $db->prepare("UPDATE document_caisse SET `chemin`=? WHERE `id_caisse`=?");
                    $req_document->execute((array($doc_caisse, $id_caisse)));
                }
            }
    }
}
//Insertion des docs du projet 

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