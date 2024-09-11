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

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Accueil</title>
		<?php include 'css.php'; ?>
	</head>
	<body style="background-image: url(<?=$image?>accueil.png);" >
		<?php
		include 'verif_menu.php';
		?>
        <main>
            <div class="container-fluid">

            <!-- Section: add employe -->
            <section class="mb-5">

                <!-- Card -->
                <div class="card card-cascade narrower">

                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h4 class="mb-0"><b> Nouveau employe </b></h4>
                    </div>
                    <!-- /Card image -->

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="md-form">
                                <input type="text" id="prenom" name="prenom" required class="form-control">
                                <label for="prenom" class="active">Prénom</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="md-form">
                                <input type="text" id="nom" name="prenom" required class="form-control">
                                <label for="nom" class="active">Nom</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="md-form">
                                <input type="text" id="date_naissance" name="date_naissance" class="form-control datepicker">
                                <label for="date_naissance" class="active">Date naissance</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="md-form">
                                <input type="text" id="lieu_naissance" name="lieu_naissance" class="form-control">
                                <label for="lieu_naissance" class="active">Lieu naissance</label>
                                </div>
                            </div>
                        </div>                 

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
            $('.datepicker').pickadate();
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