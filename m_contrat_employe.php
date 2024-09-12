<?php

include 'connexion.php';
$id = intval(htmlspecialchars($_GET['id']));
$req_employe = $db->prepare("SELECT  employe.`matricule`, employe.`prenom`, employe.`nom`, contrat_employe.date_debut, contrat_employe.date_prevu_fin, contrat_employe.montant, contrat_employe.type_contrat, `contrat_employe`.`document`
FROM `contrat_employe`
INNER JOIN `employe` ON employe.id = contrat_employe.id_employe
WHERE contrat_employe.id=?");
$req_employe->execute(array($id));
$donnee=$req_employe->fetch();
$prenom=$donnee['1'];
$nom=$donnee['2'];
$date_debut=$donnee['3'];
$date_prevu_fin=$donnee['4'];
$montant=$donnee['5'];
$type_contrat=$donnee['6'];
$document=$donnee['7'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modification contrat</title>
		<?php include 'css.php'; ?>
	</head>
	<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>wood-1963988_1280.jpg);">
		<?php
		include 'verif_menu.php';
        ?>
        <div class="container pt-4">
            
            <!-- Card -->
            <div class="card card-cascade narrower col-md-8 offset-md-2">
            
              <!-- Card image -->
                <div class="view view-cascade gradient-card-header blue-gradient">
                  <h1 class="mb-0">Modification contrat</h1>
                </div>
              <!-- /Card image -->
    
              <!-- Card content -->
              <div class="card-body card-body-cascade  table-responsive">
                  <form action="m_contrat_employe_trmnt.php" method="POST" enctype="multipart/form-data"  id="form">
                  <input type="number" name="id_contrat" value="<?=$id ?>" hidden>
                  <div class="row">
                    <h5 class="col-12">
                        Prénom : <b><?=$prenom ?></b>
                        <br>
                        Nom &nbsp&nbsp&nbsp&nbsp: <b><?=$nom ?></b>
                    </h5>
                  </div>
                  <div class="row">
                        <div class="col-md-3 ">
                            <select class="mdb-select md-form" name="type_contrat" required>
                                <option value='' disabled >Type contrat</option>

                                <option value="Stage"<?php if($type_contrat=="Stage"){echo "selected";} ?>>Stage</option>
                                <option value="Prestation de service"<?php if($type_contrat=="Prestation de service"){echo "selected";} ?>>Prestation de service</option>
                                <option value="CDD"<?php if($type_contrat=="CDD"){echo "selected";} ?>>CDD</option>
                                <option value="CDI"<?php if($type_contrat=="CDI"){echo "selected";} ?>>CDI</option>
                                <option value="Consultant"<?php if($type_contrat=="Consultant"){echo "selected";} ?>>Consultant</option>
                            </select>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                            <input type="text" id="date_debut" value="<?= $date_debut ?>" required name="date_debut" class="form-control datepicker">
                            <label for="date_debut" class="active">Date début contrat</label>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                            <input type="text" id="date_fin" value="<?= $date_debut ?>" name="date_fin" class="form-control datepicker" required>
                            <label for="date_fin" class="active">Date fin contrat</label>
                            </div>
                        </div>
                        <div class="col-md-8 ">
                            <div class="md-form">
                                <input type="number" value="<?= $montant ?>" id="montant" name="montant" required class="form-control">
                                <label for="montant" class="active">Salaire</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <input type="submit" value="Enregistrer" class="btn blue-gradient">
                    </div> 
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