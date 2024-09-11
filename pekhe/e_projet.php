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
		<title>Nouveau projet</title>
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
                  <h4 class="mb-0 col-sm-12">Nouveau projet</h4>
                </div>
              <!-- /Card image -->
    
              <!-- Card content -->
              <div class="card-body card-body-cascade  table-responsive">
                  <form action="e_projet_trmnt.php" method="POST">
                    
                    <div class="row">
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                            <input type="text" id="date_debut" value="<?= date('Y-m-d')?>" name="date_debut" class="form-control datepicker" required>
                            <label for="date_debut" class="active">Date début</label>
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="nom_projet"  name="nom_projet" class="form-control" required>
                                <label for="nom_projet" class="active">nom du projet</label>
                            </div>
                        </div>                    
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="localisation"  name="localisation" class="form-control" >
                                <label for="localisation" class="active">Localisation</label>
                            </div>
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