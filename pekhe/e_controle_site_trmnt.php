<?php
session_start(); 
include 'connexion.php';
include 'supprim_accents.php';
$verif=0;

$controleur=htmlspecialchars($_POST['controleur']);
$date_controle=htmlspecialchars($_POST['date_controle']);
$heure_debut=htmlspecialchars($_POST['heure_debut']);
$heure_fin=htmlspecialchars($_POST['heure_fin']);
$controle=htmlspecialchars($_POST['controle']);
$site_controle=htmlspecialchars($_POST['site_controle']);
$observations=htmlspecialchars($_POST['observations']);
$nbr_site_controler=htmlspecialchars($_POST['nbr_site_controler']);


$req_count = $db->query("SELECT COALESCE(MAX(id), '0') +1 FROM `controle_site` WHERE 1");
$donne=$req_count->fetch();
$id_controle=$donne['0'];
$doc='';
switch ($_FILES["pj"]['error'])
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
        $extension= strtolower(strrchr($_FILES["pj"]['name'], '.'));
        $extensions_autorisees = array('.pdf','.jpg', '.jpeg', '.png');
        if (!in_array($extension, $extensions_autorisees))
        {
            $error='Seul les fichiers d\'extension pdf, jpeg, jpg et png sont autorisés, contacter votre administrateur pour plus de renseignements';
        }
        else
        {
            $repertoire=$_SESSION['chemin_document'].'controle_site/'.$id_controle.'/';
            if (is_dir($repertoire)) 
            {
                
            }
            else
            {
                mkdir($repertoire);
            }
            $nom_document="pj";
            move_uploaded_file($_FILES["pj"]['tmp_name'], $repertoire.$nom_document.$extension);
            $doc=$repertoire.$nom_document.$extension;
        }
    }
}
//Insertin des infos sur le conrole
$req=$db->prepare("INSERT INTO `controle_site`(`id`,`date_controle`, `heure_debut`, `heure_fin`, `controle`,nbr_site_controler, `site_controle`, `observations`, `pj`, `id_controleur`, `id_user`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$result=$req->execute(array($id_controle, $date_controle, $heure_debut, $heure_fin, $controle, $nbr_site_controler, $site_controle, $observations, $doc, $controleur, $_SESSION['id_vigilus_user'])) or die(print_r($req->errorInfo()));
$nbr=$req->rowCount();

if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        alert("Contôle enregistré");
        window.location="l_controle_site.php";
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
        alert("Erreur controle non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
    
?>