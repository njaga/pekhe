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

$id = htmlspecialchars(intval($_GET['id']));
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

$req_employe = $db->prepare("SELECT employe.`id`, `matricule`, `fonction`, `prenom`, `nom`, `date_naissance`, `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, employe.`date_debut`, `note`, `nbr_enfants`, `service_militaire`, `etat_dossier`, `id_departement`, sexe, telephone, nbr_femme, contrat_employe.id, contrat_employe.type_contrat, contrat_employe.date_debut, contrat_employe.montant, contrat_employe.date_prevu_fin, employe.prime, photo, diplome, arts_martiaux, cni, date_delivrance, date_experience, telephone, document, compte_bancaire
FROM `employe` 
LEFT JOIN contrat_employe on employe.id=contrat_employe.id_employe
WHERE employe.id=? and contrat_employe.etat=1");
$req_employe->execute(array($id));
$donnees_employe = $req_employe->fetch();
$matricule = $donnees_employe['1'];
$fonction = $donnees_employe['2'];
$prenom = $donnees_employe['3'];
$nom = $donnees_employe['4'];
$date_naissance = $donnees_employe['5'];
$lieu_naissance = $donnees_employe['6'];
$adresse = $donnees_employe['7'];
$situation_matrimoniale = $donnees_employe['8'];
$niveau_experience = $donnees_employe['9'];
$date_debut = $donnees_employe['10'];
$note = $donnees_employe['11'];
$nbr_enfants = $donnees_employe['12'];
$service_militaire = $donnees_employe['13'];
$etat_dossier = $donnees_employe['14'];
$id_departement = $donnees_employe['15'];
$sexe = $donnees_employe['16'];
$telephone = $donnees_employe['17'];
$nbr_femme = $donnees_employe['18'];
$id_contrat = $donnees_employe['19'];
$type_contrat = $donnees_employe['20'];
$date_debut_contrat = $donnees_employe['21'];
$montant_contrat = $donnees_employe['22'];
$date_fin_contrat = $donnees_employe['23'];
$prime = $donnees_employe['24'];
$photo = $donnees_employe['25'];
$diplome = $donnees_employe['26'];
$arts_martiaux = $donnees_employe['27'];
$cni = $donnees_employe['28'];
$date_delivrance = $donnees_employe['29'];
$date_experience = $donnees_employe['30'];
$telephone = $donnees_employe['31'];
$document = $donnees_employe['32'];
$compte_bancaire = $donnees_employe['33'];

$req_pj = $db->prepare("SELECT `id`, `type_document`, `document`, `id_employe` 
FROM `document_employe` 
WHERE `id_employe`= ?");
$req_pj->execute(array($id));

?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification employe</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>accueil.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <main class="container-fluid">

        <div class="row">

            <!-- Section: add employe -->
            <section class="mb-5 col-10 offset-md-1">

                <!-- Card -->
                <div class="card card-cascade narrower">

                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h4 class="mb-0"><b> Modification employe </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="m_employe_trmnt.php" enctype="multipart/form-data" id="form">
                            <input type="number" name="id_employe" value="<?= $id ?>" hidden>
                            <div class="col-md-3 ">
                                <div class="md-form">
                                    <input type="date" id="date_debut" value="<?= $date_debut ?>" required name="date_debut" class="form-control ">
                                    <label for="date_debut" class="active">Date début</label>
                                </div>
                            </div>
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="browser-default custom-select md-form" name="departement" searchable="Recherhce .." required>
                                        <option value='' disabled>Département</option>
                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['0'] . "'";
                                            if ($id_departement == $donnees_departement['0']) {
                                                echo "selected";
                                            }
                                            echo ">" . $donnees_departement['1'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <input type="text" id="matricule" value="<?= $matricule ?>" name="matricule" class="form-control">
                                        <label for="matricule" class="active">Matricule</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form">
                                        <input type="text" id="fonction" value="<?= $fonction ?>" name="fonction" required class="form-control">
                                        <label for="fonction" class="active">Fonction</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="md-form">
                                        <input type="text" value="<?= $prime ?>" name="prime" id="prime" class="form-control">
                                        <label for="prime" class="active">Prime</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <input type="text" value="<?= $compte_bancaire ?>" name="compte_bancaire" id="compte_bancaire" class="form-control">
                                        <label for="compte_bancaire" class="active">N° Compte bancaire</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos employe -->
                            <div class="row">
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="prenom" value="<?= $prenom ?>" name="prenom" required class="form-control">
                                        <label for="prenom" class="active">Prénom</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="nom" value="<?= $nom ?>" name="nom" required class="form-control">
                                        <label for="nom" class="active">Nom</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" id="sexe" name="sexe" required>
                                        <option value='' disabled>Sexe</option>
                                        <option value="Homme" <?php
                                                                if ($sexe == "Homme") {
                                                                    echo "selected";
                                                                }
                                                                ?>>Homme</option>
                                        <option value="Femme" <?php
                                                                if ($sexe == "Femme") {
                                                                    echo "selected";
                                                                }
                                                                ?>>Femme</option>
                                    </select>
                                    <label for="sexe" class="active">Sexe</label>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="date" id="date_naissance" value="<?= $date_naissance ?>" name="date_naissance" class="form-control ">
                                        <label for="date_naissance" class="active">Date naissance</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="lieu_naissance" value="<?= $lieu_naissance ?>" name="lieu_naissance" class="form-control">
                                        <label for="lieu_naissance" class="active">Lieu naissance</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos employe suite -->
                            <div class="row">
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="telephone" value="<?= $telephone ?>" name="telephone" class="form-control ">
                                        <label for="telephone" class="active">N° Télélphone</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="adresse" value="<?= $adresse ?>" name="adresse" class="form-control ">
                                        <label for="adresse" class="active">Adresse</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" id="situation_matrimoniale" name="situation_matrimoniale" required>
                                        <option value='' disabled>Situation matromniale</option>
                                        <option value="Celibataire" <?php
                                                                    if ($situation_matrimoniale == "Celibataire") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Celibataire</option>
                                        <option value="Marie" <?php
                                                                if ($situation_matrimoniale == "Marie") {
                                                                    echo "selected";
                                                                }
                                                                ?>>Marie(e)</option>
                                        <option value="Divorce" <?php
                                                                if ($situation_matrimoniale == "Divorce") {
                                                                    echo "selected";
                                                                }
                                                                ?>>Divorce(e)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $nbr_femme ?>" id="nbr_femme" name="nbr_femme" required class="form-control">
                                        <label for="nbr_femme" class="active">Nbr femme(s)</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $nbr_enfants ?>" id="nbr_enfant" name="nbr_enfant" required class="form-control">
                                        <label for="nbr_enfant" class="active">Nbr enfant</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2 ">
                                    <select class="mdb-select md-form" name="diplome" id="diplome" required>
                                        <option value='' disabled selected>Dernier diplôme</option>
                                        <option value="CFEE" <?php
                                                            if ($diplome == "CFEE") {
                                                                echo "selected";
                                                            }
                                                            ?>>CFEE</option>
                                        <option value="BFEM" <?php
                                                            if ($diplome == "BFEM") {
                                                                echo "selected";
                                                            }
                                                            ?>>BFEM</option>
                                        <option value="BAC" <?php
                                                            if ($diplome == "BAC") {
                                                                echo "selected";
                                                            }
                                                            ?>>BAC</option>
                                        <option value="LICENCE" <?php
                                                            if ($diplome == "LICENCE") {
                                                                echo "selected";
                                                            }
                                                            ?>>LICENCE</option>
                                        <option value="MASTER" <?php
                                                            if ($diplome == "MASTER") {
                                                                echo "selected";
                                                            }
                                                            ?>>MASTER</option>
                                    </select>
                                    <label for="diplome">Dernier diplôme</label>
                                </div>
                                <div class="col-md-3 ">
                                    <select class="mdb-select md-form" name="service_militaire" id="service_militaire" required>
                                        <option value='' disabled>Service Militaire</option>
                                        <option value="Oui" <?php
                                                            if ($service_militaire == "Oui") {
                                                                echo "selected";
                                                            }
                                                            ?>>Oui</option>
                                        <option value="Non" <?php
                                                            if ($service_militaire == "Non") {
                                                                echo "selected";
                                                            }
                                                            ?>>Non</option>
                                    </select>
                                    <label for="service_militaire" class="active">Service Militaire</label>
                                </div>
                                <div class="col-md-3 ">
                                    <select class="mdb-select md-form" name="arts_martiaux" id="arts_martiaux" required>
                                        <option value='' disabled>Arts Martiaux</option>
                                        <option value="Oui" <?php
                                                            if ($arts_martiaux == "Oui") {
                                                                echo "selected";
                                                            }
                                                            ?>>Oui</option>
                                        <option value="Non" <?php
                                                            if ($arts_martiaux == "Non") {
                                                                echo "selected";
                                                            }
                                                            ?>>Non</option>
                                    </select>
                                    <label for="arts_martiaux" class="active">Arts Martiaux</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="text" value="<?= $niveau_experience ?>" name="niveau_experience" id="niveau_experience" class="form-control">
                                        <label for="niveau_experience" class="active">Niveau d'expérience</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="text" name="cni" id="cni" value="<?= $cni ?>" class="form-control">
                                        <label for="cni" class="active">N° CNI</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="date" name="date_delivrance" value="<?= $date_delivrance ?>" id="date_delivrance" class="form-control">
                                        <label for="date_delivrance" class="active">Date délivrance</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="date" name="date_experience" value="<?= $date_experience ?>" id="date_experience" class="form-control">
                                        <label for="date_experience" class="active">Date expiration</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <h5 class="center-text">Contrat</h5>
                            <a href="<?= $document ?>">Afficher le contrat numériser</a>
                            <br>
                            <div class="row hide">
                                <div class="col-md-3 ">
                                    <select class="mdb-select md-form" name="type_contrat" required>
                                        <option value='' disabled selected>Type contrat</option>
                                        <option value="Stage" <?php
                                                                if ($type_contrat == "Stage") {
                                                                    echo "selected";
                                                                }
                                                                ?>>Stage</option>
                                        <option value="Prestation de service" <?php
                                                                                if ($type_contrat == "Prestation de service") {
                                                                                    echo "selected";
                                                                                }
                                                                                ?>>Prestation de service</option>
                                        <option value="CDD" <?php
                                                            if ($type_contrat == "CDD") {
                                                                echo "selected";
                                                            }
                                                            ?>>CDD</option>
                                        <option value="CDI" <?php
                                                            if ($type_contrat == "CDI") {
                                                                echo "selected";
                                                            }
                                                            ?>>CDI</option>
                                        <option value="Consultant" <?php
                                                                    if ($type_contrat == "Consultant") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Consultant</option>
                                    </select>
                                </div>
                                <div class="col-md-3 ">
                                    <input type="number" hidden name="id_contrat" value="<?= $id_contrat ?>">
                                    <div class="md-form">
                                        <input type="date" id="date_debut" value="<?= $date_debut_contrat ?>" required name="date_debut" class="form-control ">
                                        <label for="date_debut" class="active">Date début contrat</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="date" id="date_fin" value="<?= $date_fin_contrat ?>" name="date_fin" class="form-control ">
                                        <label for="date_fin" class="active">Date fin contrat</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $montant_contrat  ?>" id="montant" name="montant" required class="form-control">
                                        <label for="montant" class="active">Salaire</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row hide">
                                <div class="col-md-6 ">
                                    <div class="md-form">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="contrat" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Contrat numériser</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!-- Pièce Jointes -->
                            <h5 class="center-text">Pièces jointes</h5>
                            <div class="row">
                                <div class="col-12">
                                    <?php

                                    while ($donnees_pj = $req_pj->fetch()) {
                                    ?>
                                        <a href="<?= $donnees_pj['2'] ?>"><?= strtoupper($donnees_pj['1']) ?></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a class="red-text" href="s_pj.php?id=<?= $donnees_pj['0'] ?>">Supprimer</a>
                                        <br>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="md-form">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="contrat" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Pièce jointe</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <!-- Avatar -->
                            <h5 class="center-text">Photo de l'employé</h5>
                            <a href="<?= $photo ?>">Afficher la photo</a>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="md-form">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" accept="application" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Photo de l'employé</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="font-weight-bold col-12">Etat dossier</p>

                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary form-check-label active">
                                        <input class="form-check-input" type="radio" name="etat_dossier" id="option1" value="0" autocomplete="off" <?php if ($etat_dossier == "0") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>>
                                        Dosiier incomplet
                                    </label>
                                    <label class="btn btn-primary form-check-label">
                                        <input class="form-check-input" type="radio" name="etat_dossier" id="option2" value="1" autocomplete="off" <?php if ($etat_dossier == "1") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?>> Dossier complet
                                    </label>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <input type="submit" value="Enregistrer" class="btn blue-gradient">
                            </div>
                        </form>
                    </div>
                    <!-- Card content -->

                </div>
                <!-- Card -->

            </section>
            <!-- Section: Horizontal stepper -->




        </div>
    </main>
    <span id="fin"></span>
    <?php include 'footer.php'; ?>
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
            $('#form').submit(function() {
                if (!confirm('Voulez-vous confirmer l\'enregistrement ?')) {
                    return false;
                }
            });
            <?php
            if (isset($_GET['a'])) {
            ?>
                $('.toast').toast('show')
            <?php
            }
            ?>
        });
    </script>
</body>
<style type="text/css">

</style>

</html>