<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$verif = 0;

$departement = htmlspecialchars($_POST['departement']);
$mattricule = htmlspecialchars(suppr_accents(strtoupper($_POST['matricule'])));
$fonction = htmlspecialchars(suppr_accents(strtolower(ucfirst($_POST['fonction']))));
$prenom = htmlspecialchars(suppr_accents(ucfirst(strtolower($_POST['prenom']))));
$nom = htmlspecialchars(suppr_accents(strtoupper($_POST['nom'])));
$date_naissance = htmlspecialchars(suppr_accents($_POST['date_naissance']));
$lieu_naissance = htmlspecialchars(suppr_accents(strtolower(ucfirst($_POST['lieu_naissance']))));
$adresse = htmlspecialchars(suppr_accents($_POST['adresse']));
$situation_matrimoniale = htmlspecialchars(suppr_accents($_POST['situation_matrimoniale']));
$nbr_femme = htmlspecialchars(suppr_accents($_POST['nbr_femme']));
$nbr_enfant = htmlspecialchars(suppr_accents($_POST['nbr_enfant']));
$type_contrat = htmlspecialchars(suppr_accents($_POST['type_contrat']));
$date_debut = htmlspecialchars(suppr_accents($_POST['date_debut']));
$date_prevu_fin = htmlspecialchars(suppr_accents($_POST['date_fin']));
$niveau_experience = htmlspecialchars(suppr_accents(strtoupper($_POST['niveau_experience'])));
$montant = htmlspecialchars(suppr_accents($_POST['montant']));
$etat_dossier = htmlspecialchars(suppr_accents($_POST['etat_dossier']));
$telephone = htmlspecialchars(suppr_accents($_POST['telephone']));
$service_militaire = htmlspecialchars(suppr_accents($_POST['service_militaire']));
$sexe = htmlspecialchars($_POST['sexe']);
$cni = htmlspecialchars($_POST['cni']);
$date_delivrance = htmlspecialchars($_POST['date_delivrance']);
$date_experience = htmlspecialchars($_POST['date_experience']);
$diplome = htmlspecialchars($_POST['diplome']);
$arts_martiaux = htmlspecialchars($_POST['arts_martiaux']);

//Démarrage de la transaction
$db->beginTransaction();

//Insertion des infos perso de l'employer
$req_employe = $db->prepare("INSERT INTO `employe`(`matricule`, `fonction`, `prenom`, `nom`, `sexe`, `date_naissance`, `lieu_naissance`, `adresse`, `situation_matrimoniale`, `nbr_enfants`, `id_departement`, niveau_experience, `etat_dossier`, service_militaire, date_debut, telephone, nbr_femme, `id_user`, cni, date_delivrance, date_experience, diplome, arts_martiaux) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$result = $req_employe->execute(array($mattricule, $fonction, $prenom, $nom, $sexe, $date_naissance, $lieu_naissance, $adresse, $situation_matrimoniale, $nbr_enfant, $departement, $niveau_experience, $etat_dossier, $service_militaire, $date_debut, $telephone, $nbr_femme, $_SESSION['id_vigilus_user'], $cni, $date_delivrance, $date_experience, $diplome, $arts_martiaux)) or die(print_r($req_employe->errorInfo()));
$id_employe = $db->lastInsertId();
if (!$result) {
    $verif = 1;
}

//Id du contrat
$reqCountContrat = $db->query("SELECT MAX(id) + 1 FROM `contrat_employe` WHERE 1");
$donne_contrat = $reqCountContrat->fetch();
$id_contrat = $donne_contrat['0'];
//Insertion du contrat 
switch ($_FILES["contrat"]['error']) {
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
            $extension = strtolower(strrchr($_FILES["contrat"]['name'], '.'));
            $extensions_autorisees = array('.pdf', '.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees)) {
                $error = 'Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            } else {
                $repertoire = $_SESSION['chemin_document'] . 'contrat_employes/' . $id_employe . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }
                $doc_contrat="";
                $nom_document = $id_contrat;
                move_uploaded_file($_FILES["contrat"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc_contrat = $repertoire . $nom_document . $extension;
            }
        }
}
$req_contrat = $db->prepare('INSERT INTO  `contrat_employe`(`id`, `type_contrat`, `date_debut`, `date_prevu_fin`, `montant`, `document`, `id_employe`, `id_user`) VALUES (?,?,?,?,?,?,?,?)');
$req_contrat->execute(array($id_contrat, $type_contrat, $date_debut, $date_prevu_fin, $montant, $doc_contrat, $id_employe, $_SESSION['id_vigilus_user'])) or die(print_r($req_contrat->errorInfo()));
$result = $id_contrat = $db->lastInsertId();
if (!$result) {
    $verif = 2;
}
/*Insertion des PJ */
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
                $repertoire = $_SESSION['chemin_document'] . 'employes/' . $id_employe . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }
                $nom_document = "PJ";
                move_uploaded_file($_FILES["pj"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc = $repertoire . $nom_document . $extension;
                $req = $db->prepare('INSERT INTO `document_employe`(`type_document`, `document`, `id_employe`) VALUES (?,?,?)');
                $result = $req->execute(array($nom_document, $doc, $id_employe)) or die(print_r($req->errorInfo()));
                if (!$result) {
                    $verif = 3;
                }
            }
        }
}
//Insertion de la photo
switch ($_FILES["photo"]['error']) {
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
            $extension = strtolower(strrchr($_FILES["photo"]['name'], '.'));
            $extensions_autorisees = array('.pdf', '.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees)) {
                $error = 'Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            } else {
                $repertoire = $_SESSION['chemin_document'] . 'employes/' . $id_employe . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }
                $nom_document = "photo";
                move_uploaded_file($_FILES["photo"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc = $repertoire . $nom_document . $extension;
                $req = $db->prepare('UPDATE `employe` SET `photo`=? WHERE id=?');
                $result = $req->execute(array($doc, $id_employe)) or die(print_r($req->errorInfo()));
                if (!$result) {
                    $verif = 3;
                }
            }
        }
}

if ($verif == 0) {
    //echo $verif;
    $db->commit();
?>
    <script type="text/javascript">
        //alert("Employé enregistré");
        //window.location = "e_affectation_site.php?id=" + <?= $id_employe ?> + '&v=v';
        window.location = "e_employe.php";
    </script>
<?php
    /*
    if ($departement == "3") {
        header('location:e_affectation_site.php?id=' . $id_employe . '&v=v');
    } else {
        header('location:l_employe.php');
    }
    */
} else {
    //echo $verif;            
    $db->rollback();
?>
    <script type="text/javascript">
        alert("Erreur Employé non enregistré");
        window.history.go(-1);
    </script>
<?php
}

?>