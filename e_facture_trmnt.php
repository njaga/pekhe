<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_facture=htmlspecialchars($_POST['date_facture']);
$num_facture=htmlspecialchars($_POST['num_facture']);
$commentaire=htmlspecialchars($_POST['commentaire']);
$id=htmlspecialchars($_POST['id']);

//Id du facture
$reqCountfacture = $db->query("SELECT MAX(id) + 1 FROM `facture` WHERE 1");
$donne_facture = $reqCountfacture->fetch();
$id_facture=$donne_facture['0'];
//Insertion du facture 
switch ($_FILES["facture"]['error'])
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
            $extension= strtolower(strrchr($_FILES["facture"]['name'], '.'));
            $extensions_autorisees = array('.pdf','.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees))
            {
                $error='Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            }
            else
            {
                $repertoire=$_SESSION['chemin_document'].'facture/'.$id_facture.'/';
                if (is_dir($repertoire)) 
                {
                    
                }
                else
                {
                    mkdir($repertoire);
                }
                $nom_document=$id_facture;
                move_uploaded_file($_FILES["facture"]['tmp_name'], $repertoire.$nom_document.$extension);
                $doc_facture=$repertoire.$nom_document.$extension;
            }
        }
    } 

  $req_facture=$db->prepare('INSERT INTO  `facture` (`id`, `date_facture`, `facture`, `commentaire`, `num_facture`, `id_client`, `id_user`) VALUES (?,?,?,?,?,?,?)');
$req_facture->execute(array($id_facture, $date_facture, $doc_facture, $commentaire, $num_facture, $id, $_SESSION['id_vigilus_user'])) or die(print_r($req_facture->errorInfo()));;
$nbr=$req_facture->rowCount();

if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        window.location="d_client.php?id="+<?=$id ?>;
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
        alert("Erreur facture non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
    
?>