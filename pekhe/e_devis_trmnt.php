<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_devis=htmlspecialchars($_POST['date_devis']);
$num_devis=htmlspecialchars($_POST['num_devis']);
$commentaire=htmlspecialchars($_POST['commentaire']);
$id=htmlspecialchars($_POST['id']);


//Id du devis
$reqCountDevis = $db->query("SELECT MAX(id) + 1 FROM `devis` WHERE 1");
$donne_devis = $reqCountDevis->fetch();
$id_devis=$donne_devis['0'];
//Insertion du devis 
switch ($_FILES["devis"]['error'])
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
            $extension= strtolower(strrchr($_FILES["devis"]['name'], '.'));
            $extensions_autorisees = array('.pdf','.jpg', '.jpeg', '.png');
            if (!in_array($extension, $extensions_autorisees))
            {
                $error='Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
            }
            else
            {
                $repertoire=$_SESSION['chemin_document'].'devis/'.$id_devis.'/';
                if (is_dir($repertoire)) 
                {
                    
                }
                else
                {
                    mkdir($repertoire);
                }
                $nom_document=$id_devis;
                move_uploaded_file($_FILES["devis"]['tmp_name'], $repertoire.$nom_document.$extension);
                $doc_devis=$repertoire.$nom_document.$extension;
            }
        }
    } 

if(isset($_GET['p']))
{
    $req_devis=$db->prepare('INSERT INTO  `devis` (`id`, `date_devis`, `devis`, `commentaire`, `num_devis`, `id_prospect`, `id_user`) VALUES (?,?,?,?,?,?,?)');
}
else
{
    $req_devis=$db->prepare('INSERT INTO  `devis` (`id`, `date_devis`, `devis`, `commentaire`, `num_devis`, `id_client`, `id_user`) VALUES (?,?,?,?,?,?,?)');
}
$req_devis->execute(array($id_devis, $date_devis, $doc_devis, $commentaire, $num_devis, $id, $_SESSION['id_vigilus_user'])) or die(print_r($req_devis->errorInfo()));;
$nbr=$req_devis->rowCount();

if($nbr>0)
{ 
    if(isset($_GET['p']))
    {
        ?>
        <script type="text/javascript">
        window.location = "d_prospect.php?id=" + <?=$id ?>;
        </script>
        <?php
    }
    else
    {
        ?>
        <script type="text/javascript">
        window.location = "d_client.php?id=" + <?=$id ?>;
        </script>
        <?php
    }
    
}
else
{
    ?>
<script type="text/javascript">
alert("Erreur devis non enregistré");
window.history.go(-1);
</script>
<?php
}
    
?>