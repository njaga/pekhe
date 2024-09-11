<?php
session_start();
if(!isset($_SESSION['id_vigilus_user']))
{
?>
<script type="text/javascript">
    alert("Veillez d'abord vous connectez !");
    window.location = 'index.php';

</script>
<?php
}
include 'connexion.php';
$req_employe = $db->query("SELECT `id`, CONCAT(`prenom`,' ', `nom`), `matricule`  FROM `employe` WHERE etat=1 AND `fonction` like 'controleur'");

$req_gardien = $db->query("SELECT `id`, CONCAT(`prenom`,' ', `nom`), `matricule`  FROM `employe` WHERE etat=1 AND `id_departement`=3 ");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Enregistrer contrôle</title>
		<?php include 'css.php'; ?>
	</head>
	<body style="background-image: url(<?=$image?>zedz.png);" >
		<?php
		include 'verif_menu.php';
		?>
        <main class="container-fluid">
        
            <div class="row">

            <!-- Section: add employe -->
            <section class="mb-5 col-8 offset-md-2">

                <!-- Card -->
                <div class="card card-cascade narrower">

                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header <?= $color ?>">
                        <h4 class="mb-0"><b> Enregistrer un rapport de site </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="e_rapport_site_trmnt.php" enctype="multipart/form-data"  id="form" >
                            <!-- Info département -->
                            <br>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <select class=" custom-select" name="controleur" searchable="Recherhce .." required>
                                        <option value='' disabled selected>Contrôleur</option>
                                        <?php
                                            while ($donnees_employe =$req_employe->fetch()) {
                                                echo"<option value='".$donnees_employe['0']."'  >".$donnees_employe['1']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <!-- Infos employe -->
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                    <input type="text" id="date_controle" value="<?=date('Y-m-d') ?>" required name="date_controle" required class="form-control datepicker">
                                    <label for="date_controle" class="active">Date contrôle</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                    <input type="text" id="heure_controle" name="heure_controle"  class="form-control timepicker">
                                    <label for="heure_controle" class="active">Heure
                                    </label>
                                    </div>
                                </div>
                            </div>
                             <!-- Infos controle -->       
                            <div class="row">
                                <div class="col-sm-6 col-md-6 ">
                                    <select class="mdb-select md-form" name="controle" id="controle" required>
                                        <option value='' disabled selected>Contrôle</option>
                                        <option value="Tenue de travail non conforme">Tenue de travail non conforme</option>
                                        <option value="Surpris en train de dormir">Surpris en train de dormir</option>
                                        <option value="Absence injustifiée">Absence injustifiée</option>
                                        <option value="Abandon de poste">Abandon de poste</option>
                                    </select>
                                    <label for="controle">Contrôle</label>
                                </div>
                                <div class="col-sm-6 col-md-6 ">
                                    <select class="mdb-select md-form" name="agent" id="agent" searchable="Recherhce du site .." >
                                        <option value='' disabled selected>Agent en faute</option>
                                        <?php
                                            while ($donnees_gardien=$req_gardien->fetch()) {
                                                echo"<option value='".$donnees_gardien['0']."'  >".$donnees_gardien['1']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <label for="agent">Agent en faute</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-sm-12 col-md-10">
                                    <label for="rapport_control"></label>
                                    <textarea class="form-control z-depth-1" id="rapport_control" name="rapport_control" rows="3" placeholder="Rapport de controle..."></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-sm-12 col-md-10">
                                    <label for="suivi"></label>
                                    <textarea class="form-control z-depth-1" id="suivi" name="suivi" rows="3" placeholder="Suvi ..."></textarea>
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
                                                <input type="file" name="pj"  accept="application/pdf" class="custom-file-input" id="inputGroupFile01"
                                                aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Pièce jointe</label>
                                            </div>
                                        </div>
                                    </div>
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
            var input = $('#heure_controle').pickatime({
            autoclose: true,
            'default': 'now'
            });
            

            // Manually toggle to the minutes view
            $('#check-minutes').click(function(e){
            e.stopPropagation();
            input.pickatime('show').pickatime('toggleView', 'minutes');
            });

            $('#form').submit(function () {
                if (!confirm('Voulez-vous confirmer l\'enregistrement ?')) {
                    return false;
                }
            });
            <?php
                if(isset($_GET['a']))
                {
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