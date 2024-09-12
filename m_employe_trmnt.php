<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$verif = 0;

$id = htmlspecialchars($_POST['id_employe']);
$departement = htmlspecialchars($_POST['departement']);
$mattricule = htmlspecialchars(suppr_accents(strtoupper($_POST['matricule'])));
$fonction = htmlspecialchars(suppr_accents(strtolower(ucfirst($_POST['fonction']))));
$prenom = htmlspecialchars(suppr_accents(ucfirst(strtolower($_POST['prenom']))));
$nom = htmlspecialchars(suppr_accents(strtoupper($_POST['nom'])));
$date_naissance = htmlspecialchars(suppr_accents($_POST['date_naissance']));
$lieu_naissance = htmlspecialchars(suppr_accents(strtolower(ucfirst($_POST['lieu_naissance']))));
$adresse = htmlspecialchars(suppr_accents($_POST['adresse']));
$telephone = htmlspecialchars(suppr_accents($_POST['telephone']));
$situation_matrimoniale = htmlspecialchars(suppr_accents($_POST['situation_matrimoniale']));
$nbr_enfant = htmlspecialchars(suppr_accents($_POST['nbr_enfant']));
$nbr_femme = htmlspecialchars(suppr_accents($_POST['nbr_femme']));
$etat_dossier = htmlspecialchars(suppr_accents($_POST['etat_dossier']));
$service_militaire = htmlspecialchars(suppr_accents($_POST['service_militaire']));
$sexe = htmlspecialchars(suppr_accents($_POST['sexe']));
$date_debut = htmlspecialchars(suppr_accents($_POST['date_debut']));
$prime = htmlspecialchars(suppr_accents($_POST['prime']));
$telephone = htmlspecialchars(suppr_accents($_POST['telephone']));
$service_militaire = htmlspecialchars(suppr_accents($_POST['service_militaire']));
$sexe = htmlspecialchars($_POST['sexe']);
$cni = htmlspecialchars($_POST['cni']);
$date_delivrance = htmlspecialchars($_POST['date_delivrance']);
$date_experience = htmlspecialchars($_POST['date_experience']);
$diplome = htmlspecialchars($_POST['diplome']);
$arts_martiaux = htmlspecialchars($_POST['arts_martiaux']);
$compte_bancaire = htmlspecialchars($_POST['compte_bancaire']);


$id_contrat = htmlspecialchars(suppr_accents($_POST['id_contrat']));
$type_contrat = htmlspecialchars(suppr_accents($_POST['type_contrat']));
$date_debut = htmlspecialchars(suppr_accents($_POST['date_debut']));
$date_prevu_fin = htmlspecialchars(suppr_accents($_POST['date_fin']));
$montant = htmlspecialchars($_POST['montant']);

//Démarrage de la transaction
$db->beginTransaction();

//Insertion des infos perso de l'employer
$req_employe = $db->prepare("UPDATE  `employe` SET `matricule`=?, `fonction`=?, `prenom`=?, `nom`=?, `date_naissance`=?, `lieu_naissance`=?, `adresse`=?, `situation_matrimoniale`=?, `nbr_enfants`=?, `id_departement`=?, niveau_experience=?, `etat_dossier`=?, service_militaire=?, date_debut=?, telephone=?, nbr_femme=?, `id_user`=?, sexe=?, prime=?, cni=?, date_delivrance=?, date_experience=?, diplome=?, arts_martiaux=?, compte_bancaire=? WHERE id=?");
$result = $req_employe->execute(array($mattricule, $fonction, $prenom, $nom, $date_naissance, $lieu_naissance, $adresse, $situation_matrimoniale, $nbr_enfant, $departement, $niveau_experience, $etat_dossier, $service_militaire, $date_debut, $telephone, $nbr_femme, $_SESSION['id_vigilus_user'], $sexe, $prime, $cni, $date_delivrance, $date_experience, $diplome, $arts_martiaux, $compte_bancaire, $id)) or die(print_r($req_employe->errorInfo()));
$id_employe = $id;

//COntrat
if ($id_contrat == "") {
    $req_contrat = $db->prepare('INSERT INTO  `contrat_employe`( `type_contrat`, `date_debut`, `date_prevu_fin`, `montant`, `document`, `id_employe`, `id_user`) VALUES (?,?,?,?,?,?,?)');
    $req_contrat->execute(array($type_contrat, $date_debut, $date_prevu_fin, $montant, $doc_contrat, $id_employe, $_SESSION['id_vigilus_user'])) or die(print_r($req_contrat->errorInfo()));
} else {
    $req_contrat = $db->prepare('UPDATE  `contrat_employe` SET `type_contrat`=?, `date_debut`=?, `date_prevu_fin`=?, `montant`=?, `document`=?, `id_employe`=?, `id_user`=? WHERE id=?');
    $req_contrat->execute(array($type_contrat, $date_debut, $date_prevu_fin, $montant, $doc_contrat, $id_employe, $_SESSION['id_vigilus_user'], $id_contrat)) or die(print_r($req_contrat->errorInfo()));
}

//

if (!$result) {
    $verif = 1;
}

/*Insertion des PJ */
$l_type_doc = array("", "contrat", "cni", "domicile", "casier", "demande", "bonne_vie", "diplome", "cv");

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
                $repertoire = $_SESSION['chemin_document'] . 'employes/' . $id_employe . '/';
                if (is_dir($repertoire)) {
                } else {
                    mkdir($repertoire);
                }
                $nom_document = "PJ";
                move_uploaded_file($_FILES["contrat"]['tmp_name'], $repertoire . $nom_document . $extension);
                $doc = $repertoire . $nom_document . $extension;
                $req = $db->prepare('UPDATE `document_employe` SET `document`=? WHERE `id_employe`=?');
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
        alert("Employé modifié");
        //window.location="e_employe.php";
    </script>
<?php

    header('location:l_employe.php');
} else {
    //echo $verif;            
    $db->rollback();
?>
    <script type="text/javascript">
        alert("Erreur Employé non modifé");
        window.history.go(-1);
    </script>
<?php
}

?>