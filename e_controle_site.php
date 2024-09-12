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
            <section class="mb-5 col-10 offset-md-1">

                <!-- Card -->
                <div class="card card-cascade narrower">

                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h4 class="mb-0"><b> Enregistrer un contrôle de site </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="e_controle_site_trmnt.php" enctype="multipart/form-data"  id="form" >
                            <!-- Info département -->
                            <br>
                            <div class="row">
                                <div class="col-md-4 ">
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
                                <div class="col-md-3 col-sm-6">
                                    <div class="md-form">
                                    <input type="text" id="date_controle" value="<?=date('Y-m-d') ?>" required name="date_controle" required class="form-control datepicker">
                                    <label for="date_controle" class="active">Date contrôle</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="md-form">
                                    <input type="text" id="heure_debut" name="heure_debut"  class="form-control timepicker">
                                    <label for="heure_debut" class="active">Heure début
                                    </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="md-form">
                                    <input type="text" id="heure_fin" name="heure_fin"  class="form-control timepicker">
                                    <label for="heure_fin" class="active">Heure fin
                                    </label>
                                    </div>
                                </div>
                            </div>
                             <!-- Infos controle -->       
                            <div class="row">
                                <div class="col-sm-6 col-md-3 ">
                                    <select class="mdb-select md-form" name="controle" id="controle" required>
                                        <option value='' disabled selected>Contrôle</option>
                                        <option value="Contrôler">Contrôler</option>
                                        <option value="Non Contrôler">Non Contrôler</option>
                                        <option value="Non Renseigner">Non Renseigner</option>
                                        <option value="Férié">Férié</option>
                                        <option value="Repos">Repos</option>
                                    </select>
                                    <label for="controle">Contrôle</label>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="md-form">
                                        <input type="text" id="nbr_site_controler"  required value="0" name="nbr_site_controler"  class="form-control timepicker">
                                        <label for="nbr_site_controler" class="active">Nbr Site contrôler
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-sm-6 col-md-6">
                                    <label for="site_controle"></label>
                                    <textarea class="form-control z-depth-1" id="site_controle" name="site_controle" rows="3" placeholder="Site(s) non contrôlé(s)..."></textarea>
                                </div>
                                <div class="form-group shadow-textarea col-sm-6 col-md-6">
                                    <label for="observations"></label>
                                    <textarea class="form-control z-depth-1" id="observations" name="observations" rows="3" placeholder="Observations"></textarea>
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
            var input = $('#heure_debut').pickatime({
            autoclose: true,
            'default': 'now'
            });
            var input = $('#heure_fin').pickatime({
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