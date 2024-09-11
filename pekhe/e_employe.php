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
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouveau employe</title>
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
                        <h4 class="mb-0"><b> Nouveau employe </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="e_employe_trmnt.php" enctype="multipart/form-data" id="form">
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-4 ">
                                    <select class="browser-default custom-select md-form" name="departement" searchable="Recherhce .." required>
                                        <option value='' disabled selected>Département</option>
                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['0'] . "'  >" . $donnees_departement['1'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="matricule" name="matricule" class="form-control">
                                        <label for="matricule" class="active">Matricule</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="fonction" name="fonction" required class="form-control">
                                        <label for="fonction" class="active">Fonction</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos employe -->
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="prenom" name="prenom" required class="form-control">
                                        <label for="prenom" class="active">Prénom</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="nom" name="nom" required class="form-control">
                                        <label for="nom" class="active">Nom</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" name="sexe" required>
                                        <option value='' disabled selected>Sexe</option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="date" id="date_naissance" required name="date_naissance" class="form-control ">
                                        <label for="date_naissance" class="active">Date naissance</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-form">
                                        <input type="text" id="lieu_naissance" name="lieu_naissance" class="form-control">
                                        <label for="lieu_naissance" class="active">Lieu naissance</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Infos employe suite -->
                            <div class="row">
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="telephone" name="telephone" class="form-control ">
                                        <label for="telephone" class="active">N° Télélphone</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="adresse" name="adresse" class="form-control ">
                                        <label for="adresse" class="active">Adresse</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" name="situation_matrimoniale" required>
                                        <option value='' disabled selected>Situation matrimoniale</option>
                                        <option value="Celibataire">Celibataire</option>
                                        <option value="Marie">Marie(e)</option>
                                        <option value="Divorce">Divorce(e)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="0" id="nbr_femme" name="nbr_femme" required class="form-control">
                                        <label for="nbr_femme" class="active">Nbr femme(s)</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="0" id="nbr_enfant" name="nbr_enfant" required class="form-control">
                                        <label for="nbr_enfant" class="active">Nbr enfant(s)</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Expérience et diplômes -->
                            <div class="row">
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" name="diplome" id="diplome" required>
                                        <option value='' disabled selected>Dernier diplôme</option>
                                        <option value="CFEE">CFEE</option>
                                        <option value="BFEM">BFEM</option>
                                        <option value="BAC">BAC</option>
                                        <option value="LICENCE">LICENCE</option>
                                        <option value="MASTER">MASTER</option>
                                    </select>
                                    <label for="diplome">Dernier diplôme</label>
                                </div>
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" name="service_militaire" id="service_militaire" required>
                                        <option value='' disabled>Service Militaire</option>
                                        <option value="Oui">Oui</option>
                                        <option value="Non" selected>Non</option>
                                    </select>
                                    <label for="service_militaire">Service Militaire</label>
                                </div>
                                <div class="col-md-2 ">
                                    <select class="mdb-select md-form" name="arts_martiaux" id="arts_martiaux" required>
                                        <option value='' disabled>Arts Martiaux</option>
                                        <option value="Oui">Oui</option>
                                        <option value="Non" selected>Non</option>
                                    </select>
                                    <label for="arts_martiaux">Arts Martiaux</label>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <input type="text" name="niveau_experience" id="niveau_experience" class="form-control">
                                        <label for="niveau_experience" class="active">Niveau d'expérience en sécurité</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="text" name="cni" id="cni" class="form-control">
                                        <label for="cni" class="active">N° CNI</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="date" name="date_delivrance" id="date_delivrance" class="form-control">
                                        <label for="date_delivrance" class="active">Date délivrance</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="date" name="date_experience" id="date_experience" class="form-control">
                                        <label for="date_experience" class="active">Date expiration</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!-- Contrat -->
                            <h5 class="center-text">Contrat</h5>
                            <div class="row hide">
                                <div class="col-md-3 ">
                                    <select class="mdb-select md-form" name="type_contrat" required>
                                        <option value='' disabled selected>Type contrat</option>
                                        <option value="Stage">Stage</option>
                                        <option value="Prestation de service">Prestation de service</option>
                                        <option value="CDD">CDD</option>
                                        <option value="CDI">CDI</option>
                                        <option value="Consultant">Consultant</option>
                                    </select>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="date_debut" required name="date_debut" class="form-control datepicker">
                                        <label for="date_debut" class="active">Date début contrat</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="date_fin" name="date_fin" class="form-control datepicker">
                                        <label for="date_fin" class="active">Date fin contrat</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="0" id="montant" name="montant" required class="form-control">
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
                                <div class="col-md-6 ">
                                    <div class="md-form">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="pj" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Pièce jointe</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Avatar -->
                            <h5 class="center-text">Photo de l'employé</h5>
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
                                        <input class="form-check-input" type="radio" name="etat_dossier" id="option1" value="0" autocomplete="off" checked>
                                        Dosiier incomplet
                                    </label>
                                    <label class="btn btn-primary form-check-label">
                                        <input class="form-check-input" type="radio" name="etat_dossier" id="option2" value="1" autocomplete="off"> Dossier complet
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