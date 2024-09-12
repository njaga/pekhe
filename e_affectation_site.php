<?php
session_start();

if (!isset($_SESSION['id_vigilus_user'])) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}
include 'connexion.php';
$id_employe = intval(htmlspecialchars($_GET['id']));
//liste des site de gardiennage
$req_site = $db->query("SELECT site.id, site.nom, site.localisation, site.montant_paiement 
FROM `site` 
WHERE site.etat=1");

//recupération des infos sur l'employé
if (isset($_GET['v'])) {
    $site = "Aucun";
    $ancien_montant = "0";
    $ancien_date_debut = "";
    $ancien_id = 0;

    $req_employe = $db->prepare("SELECT prenom, nom
    FROM `employe` WHERE id=?");
    $req_employe->execute(array($id_employe));
    $donnees_employe = $req_employe->fetch();
    $prenom = $donnees_employe['0'];
    $nom = $donnees_employe['1'];
} else {
    $req_employe_other = $db->prepare("SELECT CONCAT(site.nom,' ', site.localisation), affectation_site.montant, CONCAT(DATE_FORMAT(affectation_site.date_debut, '%d'), '/', DATE_FORMAT(affectation_site.date_debut, '%m'),'/', DATE_FORMAT(affectation_site.date_debut, '%Y')), employe.prenom, employe.nom, affectation_site.id
    FROM `affectation_site` 
    INNER JOIN site ON affectation_site.id_site=site.id
    INNER JOIN employe ON affectation_site.id_employe=employe.id
    WHERE affectation_site.id=(SELECT MAX(id)
    FROM `affectation_site`
    WHERE id_employe=?)");
    $req_employe_other->execute(array($id_employe));
    $donnees_employe = $req_employe_other->fetch();
    $site = $donnees_employe['0'];
    $ancien_montant = $donnees_employe['1'];
    $ancien_date_debut = $donnees_employe['2'];
    $prenom = $donnees_employe['3'];
    $nom = $donnees_employe['4'];
    $ancien_id = $donnees_employe['5'];

    $req_employe = $db->prepare("SELECT prenom, nom
    FROM `employe` WHERE id=?");
    $req_employe->execute(array($id_employe));
    $donnees_employe = $req_employe->fetch();
    $prenom = $donnees_employe['0'];
    $nom = $donnees_employe['1'];
    if (is_null($ancien_id)) {
        $ancien_id = 0;
        $ancien_montant = 0;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Affectation d'un gardient</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>color-2174065_1280.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container">

        <!-- Card -->
        <div class="card card-cascade narrower col-8 offset-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Affectation d'un gardien</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="e_affectation_site_trmnt.php" method="POST">
                    <input type="number" name="ancien_id" value="<?= $ancien_id ?>" hidden>
                    <div class="row">
                        <h5 class="col-12">
                            Gardien : <b><?= $prenom . " " . $nom ?></b>
                            <br>
                            Ancien site : <b><?= $site ?></b>
                            <br>
                            Ancien salaire : <b><?= $id_employe ?></b>
                        </h5>
                    </div>
                    <input type="number" name="id_employe" value="<?= $_GET['id'] ?>" hidden>
                    <div class="row">
                        <div class="col-md-8 ">
                            <select class="mdb-select md-form" name="site" id="site" searchable="Recherhce site .." required>
                                <option value='' disabled selected>Sites de gardeinnage</option>
                                <?php
                                while ($donnees_site = $req_site->fetch()) {
                                    echo "<option value='" . $donnees_site['0'] . "'  >" . $donnees_site['1'] . " => " . $donnees_site['3'] . "</option>";
                                }
                                ?>

                            </select>
                            <label for="site">Nouveau site de gardiennage</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="equipe" required>
                                <option value='' disabled selected>Equipe de Jour/Nuit</option>
                                <option value="Jour">Jour</option>
                                <option value="Nuit">Nuit</option>
                                <option value="Mixte">Mixte</option>
                            </select>
                        </div>
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" id="date_debut" name="date_debut" class="form-control datepicker">
                                <label for="date_debut" class="active">Date début affectation</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="number" id="montant" value="<?= $ancien_montant ?>" required name="montant" class="form-control ">
                                <label for="montant" class="active">Nouveau salaire</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="note"></label>
                            <textarea class="form-control z-depth-1" id="note" name="note" rows="3" placeholder="Mettez une note..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Enregistrer</button>
                        </div>
                    </div>
                    <br>
                </form>
                <!-- Card content -->

            </div>
            <!-- Card -->
        </div>
        <br>




        <span id="fin"></span>
        <?php include 'js.php'; ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.mdb-select').materialSelect();
                $('.datepicker').pickadate({
                    // Escape any “rule” characters with an exclamation mark (!).
                    format: 'yyyy-mm-dd',
                    formatSubmit: 'yyyy/mm/dd',
                    hiddenPrefix: 'prefix__',
                    hiddenSuffix: '__suffix'
                });



            });
        </script>
</body>
<style type="text/css">

</style>

</html>