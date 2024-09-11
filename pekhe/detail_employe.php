<?php
session_start();
include 'connexion.php';
$id = intval(htmlspecialchars($_GET['id']));

$req = $db->prepare("SELECT employe.id, `matricule`, `prenom`, employe.nom, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y')), `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, `note`, `nbr_enfants`, departement.nom , `fonction`, employe.sexe, employe.service_militaire, photo, diplome, arts_martiaux, cni, CONCAT(DATE_FORMAT(`date_delivrance`, '%d'), '/', DATE_FORMAT(`date_delivrance`, '%m'),'/', DATE_FORMAT(`date_delivrance`, '%Y')), CONCAT(DATE_FORMAT(`date_experience`, '%d'), '/', DATE_FORMAT(`date_experience`, '%m'),'/', DATE_FORMAT(`date_experience`, '%Y')), telephone, compte_bancaire
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE employe.id=?");
$req->execute(array($id));
$donnees = $req->fetch();
$matricule = $donnees['1'];
$prenom = $donnees['2'];
$nom = $donnees['3'];
$date_naissance = $donnees['4'];
$lieu_naissance = $donnees['5'];
$adresse = $donnees['6'];
$situation_matrimoniale = $donnees['7'];
$niveau_experience = $donnees['8'];
$note = $donnees['9'];
$nbr_enfant = $donnees['10'];
$departement = $donnees['11'];
$fonction = strtoupper($donnees['12']);
$sexe = $donnees['13'];
$service_militaire = $donnees['14'];
$photo = $donnees['15'];
$diplome = $donnees['16'];
$arts_martiaux = $donnees['17'];
$cni = $donnees['18'];
$date_delivrence = $donnees['19'];
$date_expiration = $donnees['20'];
$telephone = $donnees['21'];
$compte_bancaire = $donnees['22'];
$req->closeCursor();

$req_contrat = $db->prepare("SELECT type_contrat, montant, document, CONCAT(DATE_FORMAT(`date_debut`, '%d'), '/', DATE_FORMAT(`date_debut`, '%m'),'/', DATE_FORMAT(`date_debut`, '%Y')), CONCAT(DATE_FORMAT(`date_prevu_fin`, '%d'), '/', DATE_FORMAT(`date_prevu_fin`, '%m'),'/', DATE_FORMAT(`date_prevu_fin`, '%Y')), CONCAT(DATE_FORMAT(`date_fin`, '%d'), '/', DATE_FORMAT(`date_fin`, '%m'),'/', DATE_FORMAT(`date_fin`, '%Y')), motif
FROM `contrat_employe` 
WHERE id_employe=?
ORDER BY contrat_employe.date_debut DESC");
$req_contrat->execute(array($id));

$req_pj = $db->prepare("SELECT id, type_document, document
FROM `document_employe` 
WHERE id_employe=?
");
$req_pj->execute(array($id));

$req_nbr_abs = $db->prepare("SELECT COUNT(id_employe_remplace) FROM `absence_remplacement` WHERE id_employe_remplace=?
");
$req_nbr_abs->execute(array($id));
$donnee_nbr_abs = $req_nbr_abs->fetch();
$nbr_abs = $donnee_nbr_abs['0'];

$req_nbr_hs = $db->prepare("SELECT COUNT(id_employe_remplacant) FROM `absence_remplacement` WHERE id_employe_remplacant=?
");
$req_nbr_hs->execute(array($id));
$donnee_nbr_hs = $req_nbr_hs->fetch();
$nbr_hs = $donnee_nbr_hs['0'];

$req_sanction = $db->prepare("SELECT CONCAT(DATE_FORMAT(`date_sanction`, '%d'), '/', DATE_FORMAT(`date_sanction`, '%m'),'/', DATE_FORMAT(`date_sanction`, '%Y')), sanction, pj FROM `sanction_employe` WHERE id_employe=?
");
$req_sanction->execute(array($id));

//Recupération des dodation
$req_dotation = $db->prepare("SELECT  `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, CONCAT(user.prenom, ' ', user.nom), CONCAT(DATE_FORMAT(`date_dotation`, '%d'), '/', DATE_FORMAT(`date_dotation`, '%m'),'/', DATE_FORMAT(`date_dotation`, '%Y')),  blouson, pantalon_parka, pancho_de_pluie
FROM `dotation_art_gard`
INNER JOIN user on dotation_art_gard.id_user=user.id
WHERE agent=? ORDER BY date_dotation DESC");
$req_dotation->execute(array($id));

//Recupération des affectations
$req_affactation = $db->prepare("SELECT planning_agent.date_debut, planning_agent.date_fin, site.nom
FROM `planning_agent`
INNER JOIN site ON site.id=planning_agent.id_site
WHERE planning_agent.id_agent=?");
$req_affactation->execute(array($id));

?>
<!DOCTYPE html>
<html>

<head>
    <title>Détail de l'employé</title>
    <?php include 'css.php'; ?>
</head>

<body class="fixed-sn white-skin" style="background-image: url(<?= $image ?>accueil.png);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid" style="margin-top: -65px;">
        <!-- Section: Team v.1 -->
        <section class="section team-section">

            <!-- Grid row -->
            <div class="row ">
                <!-- Grid column -->
                <div class="col-md-12">

                    <!-- Card -->
                    <div class="card profile-card">

                        <!-- Avatar -->
                        <div class="avatar z-depth-1-half mb-4">
                            <img src="<?= $photo ?>" class="rounded-circle" alt="Photo de l'employé">
                        </div>
                        <div class="card-body card-body-cascade">
                            <!-- Grid row -->
                            <div class="row">
                                <h3 class="mb-2 font-weight-bold col-md-12"><strong><?= $prenom, " " . $nom ?> :
                                        <span class="font-weight-bold blue-text mb-4"> <?= $fonction ?></span> </strong> / 
                                        <u>MATRICULE : <?= $matricule ?></u>
                                </h3>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form12" value="<?= $date_naissance ?>" class="form-control form-control-sm" disabled>
                                        <label for="form12" class="disabled">Date naissance</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form3" value="<?= $lieu_naissance ?>" class="form-control form-control-sm" disabled>
                                        <label for="form3" class="disabled">Lieu de naissance</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form4" value="<?= $sexe ?>" class="form-control form-control-sm" disabled>
                                        <label for="form4" class="disabled">Sexe</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form4" value="<?= $situation_matrimoniale ?>" class="form-control form-control-sm" disabled>
                                        <label for="form4" class="disabled">Situation matrimoniale</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form4" value="<?= $nbr_enfant ?>" class="form-control form-control-sm" disabled>
                                        <label for="form4" class="disabled">Enfant(s)</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form4" value="<?php echo  $cni.' du '.$date_delivrence ?>" class="form-control form-control-sm" disabled>
                                        <label for="form4" class="disabled">CNI</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form6" value="<?= $adresse ?>" class="form-control form-control-sm" disabled>
                                        <label for="form6" class="">Adresse</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form6" value="<?= $telephone ?>" class="form-control form-control-sm" disabled>
                                        <label for="form6" class="">Télélphone</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form8" disabled value="<?= $diplome ?>" class="form-control form-control-sm">
                                        <label for="form8" class="">Diplôme</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form9" disabled value="<?= $service_militaire ?>" class=" form-control form-control-sm">
                                        <label for="form9" class="">Service Militaire</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form9" disabled value="<?= $arts_martiaux ?>" class=" form-control form-control-sm">
                                        <label for="form9" class="">Arts Martiaux</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form8" disabled value="<?= $niveau_experience ?>" class="form-control form-control-sm">
                                        <label for="form8" class="">Expérience</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="md-form form-sm mb-0">
                                        <input type="text" id="form8" disabled value="<?= $compte_bancaire ?>" class="form-control form-control-sm">
                                        <label for="form8" class="">N° de compte</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                <h5 class="font-weight-bold dark-grey-text text-center">Contrats<span class="text-muted"></span></h5>

                                    <p class="mt-4 text-muted">
                                    </p>
                                    <?php
                                    while ($donnees_contrat = $req_contrat->fetch()) {
                                        $type_contrat = $donnees_contrat['0'];
                                        $montant = $donnees_contrat['1'];
                                        $document = $donnees_contrat['2'];
                                        $date_debut = $donnees_contrat['3'];
                                        $date_prevu_fin = $donnees_contrat['4'];
                                        $date_fin = $donnees_contrat['5'];
                                        $motif = $donnees_contrat['6'];
                                        if($date_fin==""){
                                            $date_fin=" à nos jours";
                                        }
                                        echo "<p>";
                                        if ($date_fin == NULL) {
                                            echo $type_contrat . " : " . $date_debut . " - " . $date_prevu_fin;
                                        } else {
                                            echo $type_contrat . " : " . $date_debut . " - " . $date_fin . " ; " . $motif;
                                        }
                                        echo "</p>";
                                    }
                                    ?>
                                    <p class="mt-4 text-muted">
                                        <b>Nbr d'absence : </b> <?= $nbr_abs ?>
                                    </p>
                                    <p class="mt-4 text-muted">
                                        <b>Nbr heure sup : </b> <?= $nbr_hs ?>
                                    </p>
                                    <p class="mt-4 text-muted">
                                        <b><u>Sanction(s)</u></b>
                                        <br>
                                        <?php
                                        while ($donnees_sanction = $req_sanction->fetch()) {
                                            echo $donnees_sanction['0'] . " : " . $donnees_sanction['1'] . "<a href='" . $donnees_sanction['2'] . "'> => PJ</a>";
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold dark-grey-text text-center">Affectations<span class="text-muted"></span></h5>
                                    <br>
                                    <?php
                                    while ($donnees_affectaion = $req_affactation->fetch()) {
                                        $date_debut = $donnees_affectaion['0'];
                                        $date_fin = $donnees_affectaion['1'];
                                        if($date_fin==""){
                                            $date_fin=" à nos jours";
                                        }
                                        $nom_site = $donnees_affectaion['2'];
                                        echo " - " . $nom_site . " : " . $date_debut . " - " . $date_fin . "</br>";
                                    }
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold dark-grey-text text-center">Liste des dotations<span class="text-muted"></span></h5>
                                    <br>
                                    <?php
                                    while ($donnees_dotation = $req_dotation->fetch()) {
                                        $lacoste = $donnees_dotation['0'];
                                        $veste_normale = $donnees_dotation['1'];
                                        $veste_parka = $donnees_dotation['2'];
                                        $chaussure_ville = $donnees_dotation['3'];
                                        $chaussure_securite = $donnees_dotation['4'];
                                        $tonfa = $donnees_dotation['5'];
                                        $ceinturon = $donnees_dotation['6'];
                                        $epaulettes = $donnees_dotation['7'];
                                        $chemise = $donnees_dotation['8'];
                                        $pantalon_simple = $donnees_dotation['9'];
                                        $badge = $donnees_dotation['10'];
                                        $kepi = $donnees_dotation['11'];
                                        $casquette = $donnees_dotation['12'];
                                        $cravate = $donnees_dotation['13'];
                                        $combinaison = $donnees_dotation['14'];
                                        $user = $donnees_dotation['15'];
                                        $date_dotation = $donnees_dotation['16'];
                                        $blouson = $donnees_dotation['17'];
                                        $pantalon_parka = $donnees_dotation['18'];
                                        $pancho_de_pluie = $donnees_dotation['19'];

                                        echo "<b>" . $date_dotation . "</b> <br>";
                                        if ($lacoste >= 1) {
                                            echo "- Lacoste : " . str_pad($lacoste, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($veste_normale >= 1) {
                                            echo "- Veste Normale : " . str_pad($veste_normale, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($veste_parka >= 1) {
                                            echo "- Veste Parka : " . str_pad($veste_parka, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($chaussure_ville >= 1) {
                                            echo "- Chaussure Ville : " . str_pad($chaussure_ville, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($chaussure_securite >= 1) {
                                            echo "- Chaussure Sécurité : " . str_pad($chaussure_securite, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($tonfa >= 1) {
                                            echo "- TOnfa : " . str_pad($tonfa, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($ceinturon >= 1) {
                                            echo "- Ceinturon : " . str_pad($ceinturon, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($epaulettes >= 1) {
                                            echo "- Epaulettes : " . str_pad($epaulettes, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($chemise >= 1) {
                                            echo "- Chemise : " . str_pad($chemise, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($pantalon_simple >= 1) {
                                            echo "- Pantalon Simple : " . str_pad($pantalon_simple, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($kepi >= 1) {
                                            echo "- Kepi : " . str_pad($kepi, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($casquette >= 1) {
                                            echo "- Casquette : " . str_pad($casquette, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($cravate >= 1) {
                                            echo "- Cravate : " . str_pad($cravate, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($combinaison >= 1) {
                                            echo "- Combinaison : " . str_pad($combinaison, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                        if ($blouson >= 1) {
                                            echo "- Blousson : " . str_pad($blouson, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }

                                        if ($pantalon_parka >= 1) {
                                            echo "- Pantalon Parka : " . str_pad($pantalon_parka, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }

                                        if ($pancho_de_pluie >= 1) {
                                            echo "- Pancho de pluie : " . str_pad($pancho_de_pluie, 2, "0", STR_PAD_LEFT) . "</br>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
<?php include 'footer.php'; ?>
<?php include 'js.php'; ?>
<style type="text/css">
    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {

    })
</script>

</html>