<?php
session_start(); 
include 'connexion.php';
include 'supprim_accents.php';
$verif=0;

$id_controle=htmlspecialchars($_POST['id_controle']);
$controleur=htmlspecialchars($_POST['controleur']);
$date_controle=htmlspecialchars($_POST['date_controle']);
$heure_controle=htmlspecialchars($_POST['heure_controle']);
$controle=htmlspecialchars($_POST['controle']);
$rapport_control=htmlspecialchars($_POST['rapport_control']);
$suivi=htmlspecialchars($_POST['suivi']);
$id_gardien=htmlspecialchars($_POST['agent']);



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
            $repertoire=$_SESSION['chemin_document'].'rapport_control/'.$id_controle.'/';
            if (is_dir($repertoire)) 
            {
                
            }
            else
            {
                mkdir($repertoire);
            }
            $nom_document="PJ";
            move_uploaded_file($_FILES["pj"]['tmp_name'], $repertoire.$nom_document.$extension);
            $doc=$repertoire.$nom_document.$extension;
        }
    }
}

if($doc=='')
{
    $req=$db->prepare("UPDATE `rapport_control` SET `date_controle`=?, `heure_controle`=?, `controle`=?, `rapport_control`=?, `id_controleur`=?, `id_user`=?, id_gardien=?, suivi=? WHERE id=?");
    $result=$req->execute(array($date_controle, $heure_controle, $controle, $rapport_control, $controleur, $_SESSION['id_vigilus_user'], $id_gardien, $suivi, $id_controle)) or die(print_r($req->errorInfo()));
}
else
{
    $req=$db->prepare("UPDATE `rapport_control` SET `date_controle`=?, `heure_controle`=?, `controle`=?, `rapport_control`=?, `pj`=?, `id_controleur`=?, `id_user`=?, id_gardien=?, suivi=? WHERE id=?");
    $result=$req->execute(array($date_controle, $heure_controle, $controle, $rapport_control, $doc, $controleur, $_SESSION['id_vigilus_user'], $id_gardien, $suivi, $id_controle)) or die(print_r($req->errorInfo()));
}
$nbr=$req->rowCount();

 ?>
<script type="text/javascript">
    alert("Contôle modifié");
    window.location="l_rapport_site.php";
</script>