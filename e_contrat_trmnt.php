<?php
$type_contrat=htmlspecialchars(suppr_accents($_POST['type_contrat']));
$date_debut=htmlspecialchars(suppr_accents($_POST['date_debut']));
$date_prevu_fin=htmlspecialchars(suppr_accents($_POST['date_fin']));
$montant=htmlspecialchars(suppr_accents($_POST['montant']));
//Id du contrat
$reqCountContrat = $db->query("SELECT MAX(id) + 1 FROM `contrat_employe` WHERE 1");
$donne_contrat = $reqCountContrat->fetch();
$id_contrat=$donne_contrat['0'];
//Insertion du contrat 
switch ($_FILES["contrat"]['error'])
    {
        case 1: // UPLOAD_ERR_INI_SIZE
        $error="Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
        break;
        case 2: // UPLOAD_ERR_FORM_SIZE
        $error= "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
        break;
        case 3: // UPLOAD_ERR_PARTIAL
        $error= "L'envoi du fichier a été interrompu pendant le transfert !";
        break;
        case 4: // UPLOAD_ERR_NO_FILE
        $doc='';
        break;
        default:
        {
            // Testons si l'extension est autorisée
            $extension= strtolower(strrchr($_FILES["contrat"]['name'], '.'));
            $extensions_autorisees = array('.pdf','.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees))
            {
                $error='Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            }
            else
            {
                $repertoire=$_SESSION['chemin_document'].'contrat_employes/'.$id_employe.'/';
                if (is_dir($repertoire)) 
                {
                    
                }
                else
                {
                    mkdir($repertoire);
                }
                $nom_document="contrat";
                move_uploaded_file($_FILES["contrat"]['tmp_name'], $repertoire.$nom_document.$extension);
                $doc_contrat=$repertoire.$nom_document.$extension;
            }
        }
    } 
$req_contrat=$db->prepare('INSERT INTO  `contrat_employe`(`id`, `type_contrat`, `date_debut`, `date_prevu_fin`, `montant`, `document`, `id_employe`, `id_user`) VALUES (?,?,?,?,?,?,?,?)');
$req_contrat->execute(array($id_contrat, $type_contrat, $date_debut, $date_prevu_fin, $montant, $doc_contrat, $id_employe, $_SESSION['id_vigilus_user'])) or die(print_r($req_contrat->errorInfo()));;
$result=$id_contrat = $db->lastInsertId();
?>