<?php

include 'connexion.php';
$req_site = $db->query("SELECT id, `nom`, `localisation` FROM `site` WHERE etat=1");
$req_employe_remplacer = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom, site.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN affectation_site ON affectation_site.id_employe=employe.id
INNER JOIN site ON affectation_site.id_site=site.id
WHERE departement.id=3 AND employe.etat=1 AND affectation_site.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");
$req_employe_remplacant = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom, site.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN affectation_site ON affectation_site.id_employe=employe.id
INNER JOIN site ON affectation_site.id_site=site.id
WHERE departement.id=3 AND employe.etat=1 AND affectation_site.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");

$id= intval(htmlspecialchars($_GET['id']));
$req_abs_remp = $db->prepare("SELECT `id_site`, `id_employe_remplace`, `montant_retirer`, `id_employe_remplacant`, `montant_heure_sup`, `date_absence`, `motif`, motif_absence, motif_hs FROM `absence_remplacement` WHERE id=?");
$req_abs_remp->execute(array($id));
$donnees_abs_remp = $req_abs_remp->fetch();
$id_site=$donnees_abs_remp['0'];
$id_employe_remplace=$donnees_abs_remp['1'];
$montant_retirer=$donnees_abs_remp['2'];
$id_employe_remplacant=$donnees_abs_remp['3'];
$montant_heure_sup=$donnees_abs_remp['4'];
$date_absence=$donnees_abs_remp['5'];
$motif=$donnees_abs_remp['6'];
$motif_absence=$donnees_abs_remp['7'];
$motif_hs=$donnees_abs_remp['8'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Absence remplacement d'un gardien</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>color-2174065_1280.png);">
    <?php
		include 'verif_menu.php';
        ?>
    <div class="container">

        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0">Modification Absence / Remplacement </h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_abs_remp_trmnt.php" method="POST">
                    <input type="number" name="id" value="<?=$id ?>" hidden>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" id="date_remplacement" value="<?= $date_absence ?>"
                                    name="date_remplacement" class="form-control datepicker" required>
                                <label for="date_remplacement" class="active">Date absence</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 ">
                            <select class="mdb-select md-form" name="site" id="site" searchable="Recherhce du site .."
                                required>
                                <option value='' disabled selected>Site de gardiennage</option>
                                <?php
                                    while ($donnees_site =$req_site->fetch()) {
                                        echo"<option value='".$donnees_site['0']."'";
                                        if($id_site==$donnees_site['0'])
                                        {
                                            echo"selected";
                                        }  
                                        echo">".$donnees_site['1']." == ".$donnees_site['2']."</option>";
                                    }
                                ?>
                            </select>
                            <label for="site">Site de gardiennage</label>
                        </div>
                    </div>
                    <h5 class="text-center"><b>Gardient Absent</b></h5>
                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="employe_remplace" id="employe_remplace"
                                searchable="Recherhce du site ..">
                                <option value=''>Néant</option>
                                <?php
                                    while ($donnees_employe_remplacer=$req_employe_remplacer->fetch()) {
                                        echo"<option value='".$donnees_employe_remplacer['0']."'";
                                        if($id_employe_remplace==$donnees_employe_remplacer['0'])
                                        {
                                            echo"selected";
                                        }
                                        echo">".$donnees_employe_remplacer['2']." ".$donnees_employe_remplacer['3']."==> ".$donnees_employe_remplacer['4']."</option>";
                                    }
                                ?>
                            </select>
                            <label for="employe_remplace">Gardien absent</label>
                        </div>
                        <div class="col-md-4 ">
                            <select class="mdb-select md-form" name="motif_absence" id="motif_absence">
                                <option value=''>Motif absence</option>
                                <option value="Absence non justifiée"
                                    <?php if($motif_absence=="Absence non justifiée"){echo"selected";} ?>>Absence non
                                    justifiée</option>
                                <option value="Baptême" <?php if($motif_absence=="Baptême"){echo"selected";} ?>>Baptême
                                </option>
                                <option value="Congès" <?php if($motif_absence=="Congès"){echo"selected";} ?>>Congès
                                </option>
                                <option value="Décès" <?php if($motif_absence=="Décès"){echo"selected";} ?>>Décès
                                </option>
                                <option value="Indisponibilite"
                                    <?php if($motif_absence=="Indisponibilite"){echo"selected";} ?>>Indisponibilite
                                </option>
                                <option value="Mariage" <?php if($motif_absence=="Mariage"){echo"selected";} ?>>Mariage
                                </option>
                                <option value="Maladie" <?php if($motif_absence=="Maladie"){echo"selected";} ?>>Maladie
                                </option>
                                <option value="Mise à pied" <?php if($motif_absence=="Mise à pied"){echo"selected";} ?>>
                                    Mise à pied</option>
                                <option value="Permission" <?php if($motif_absence=="Permission"){echo"selected";} ?>>
                                    Permission</option>
                                <option value="Repos médical"
                                    <?php if($motif_absence=="Repos médical"){echo"selected";} ?>>Repos médical</option>
                            </select>
                            <label for="motif_absence">Motif absence</label>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                                <input type="number" id="montant_retirer" value="<?=$montant_retirer ?>" required
                                    name="montant_retirer" class="form-control ">
                                <label for="montant_retirer" class="active">Montant retenu</label>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center"><b>Gardient Supplémentaire</b></h5>
                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="employe_remplacant" id="employe_remplacant"
                                searchable="Recherhce gardien ..">
                                <option value=''>Néant</option>
                                <?php
                                    while ($donnees_employe_remplacant=$req_employe_remplacant->fetch()) {
                                        echo"<option value='".$donnees_employe_remplacant['0']."'";
                                        if($id_employe_remplacant==$donnees_employe_remplacant['0'])
                                        {
                                            echo"selected";
                                        }
                                        echo" >".$donnees_employe_remplacant['2']." ".$donnees_employe_remplacant['3']."==> ".$donnees_employe_remplacant['4']."</option>";
                                    }
                                ?>
                            </select>
                            <label for="employe_remplacant">Gardien Supplémentaire</label>
                        </div>
                        <div class="col-md-4 ">
                            <select class="mdb-select md-form" name="motif_hs" id="motif_hs">
                                <option value=''>Motif heure sup</option>
                                <option value="Complément" <?php if($motif_hs=="Complément"){echo"selected";} ?>>
                                    Complément</option>
                                <option value="Supplémentaire"
                                    <?php if($motif_hs=="Supplémentaire"){echo"selected";} ?>>Supplémentaire</option>
                                <option value="Renfort" <?php if($motif_hs=="Renfort"){echo"selected";} ?>>Renfort
                                </option>
                            </select>
                            <label for="motif_hs">Motif absence</label>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                                <input type="number" id="montant_heure_sup" value="<?=$montant_heure_sup ?>" required
                                    name="montant_heure_sup" class="form-control ">
                                <label for="montant_heure_sup" class="active">Montant heure sup</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="motif"></label>
                            <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3"
                                placeholder="Motif de l'absence..."><?= $motif ?></textarea>
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