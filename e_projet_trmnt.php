<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_debut = htmlspecialchars($_POST['date_debut']);
$nom_projet = htmlspecialchars($_POST['nom_projet']);
$localisation = htmlspecialchars($_POST['localisation']);
$commercial = htmlspecialchars($_POST['commercial']);
$departement = htmlspecialchars($_POST['departement']);

$reponse = $db->prepare("INSERT INTO `projet`(`date_debut`, nom_projet, `localisation`, id_commercial, id_departement, `id_user`) VALUES (?,?,?,?,?,?)");
$reponse->execute(array($date_debut, $nom_projet, $localisation, $commercial, $departement, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

$id_projet = $db->lastInsertId();

//Insertion des docs du projet 
switch ($_FILES["bc_client"]['error']) {
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
            $extension = strtolower(strrchr($_FILES["bc_client"]['name'], '.'));
            $extensions_autorisees = array('.pdf', '.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees)) {
                $error = 'Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            } else {
                $repertoire = $_SESSION['chemin_document'] . 'projet/' . $id_projet . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }
                $nom_document = "BC";
                move_uploaded_file($_FILES["bc_client"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc_projet = $repertoire . $nom_document . $extension;

                $req_document = $db->prepare("INSERT INTO document_projet (`type_document`, `nom_document`, `chemin`, `id_projet`, id_user) VALUES (?,?,?,?,?)");
                $req_document->execute((array("BC", "BC Client", $doc_projet, $id_projet, $_SESSION['id_vigilus_user'])));
            }
        }
}

if ($nbr > 0) {
?>
    <script type="text/javascript">
        alert("Projet enregistré");
        window.location = "l_projet.php";
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : projet non enregistré");
        window.history.go(-1);
    </script>
<?php
}
?>