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
$id=intval(htmlspecialchars($_GET['id']));
//liste des site de gardiennage
$req_site = $db->query("SELECT site.id, site.nom, site.localisation, site.montant_paiement 
FROM `site` 
WHERE site.etat=1");

//recupération des infos sur l'employé
$req_affectation = $db->prepare("SELECT `equipe`, `date_debut`, `note`, `montant`, `id_employe`, `id_site` FROM `affectation_site` WHERE id=?");
$req_affectation->execute(array($id));
$donnees_affectation = $req_affectation->fetch();
$equipe = $donnees_affectation['0'];
$date_debut = $donnees_affectation['1'];
$note = $donnees_affectation['2'];
$montant = $donnees_affectation['3'];
$id_employe = $donnees_affectation['4'];
$id_site = $donnees_affectation['5'];

$req_employe = $db->prepare("SELECT prenom, nom
FROM `employe` WHERE id=?");
$req_employe->execute(array($id_employe));
$donnees_employe = $req_employe->fetch();
$prenom = $donnees_employe['0'];
$nom = $donnees_employe['1'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Modification d'une affectation </title>
		<?php include 'css.php'; ?>
	</head>
	<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>color-2174065_1280.png);">
		<?php
		include 'verif_menu.php';
        ?>
        <div class="container">
            
            <!-- Card -->
            <div class="card card-cascade narrower col-8 offset-2">
            
              <!-- Card image -->
                <div class="view view-cascade gradient-card-header blue-gradient">
                  <h1 class="mb-0">Modificaiton d'une affectation</h1>
                </div>
              <!-- /Card image -->
    
              <!-- Card content -->
              <div class="card-body card-body-cascade  table-responsive">
                  <form action="m_affectation_site_trmnt.php" method="POST">
                      <input type="number" name="id" value="<?=$_GET['id'] ?>" hidden>
                      <div class="row">
                        <div class="col-md-8 ">
                            <select class="mdb-select md-form" name="site" id="site" searchable="Recherhce site .." required>
                                <option value='' disabled selected>Sites de gardeinnage</option>
                                <?php
                                    while ($donnees_site =$req_site->fetch()) {
                                        echo"<option value='".$donnees_site['0']."'";
                                        if($id_site==$donnees_site['0'])
                                        {
                                            echo"selected";
                                        }
                                        echo" >".$donnees_site['1']." => ".$donnees_site['3']."</option>";
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
                                <option value="Jour" <?php if($equipe=="Jour"){echo"selected";} ?>>Jour</option>
                                <option value="Nuit" <?php if($equipe=="Nuit"){echo"selected";} ?>>Nuit</option>
                                <option value="Mixte" <?php if($equipe=="Mixte"){echo"selected";} ?>>Mixte</option>
                            </select>
                        </div>
                        <div class="col-md-5 ">
                            <div class="md-form">
                            <input type="text" id="date_debut" value="<?= $date_debut ?>" name="date_debut" class="form-control datepicker">
                            <label for="date_debut"  class="active">Date début affectation</label>
                            </div>
                        </div>
                            
                      </div>
                      <div class="row">
                        <div class="col-md-5 ">
                                <div class="md-form">
                                <input type="number" id="montant"value="<?= $montant ?>" required name="montant" class="form-control ">
                                <label for="montant" class="active">Salaire</label>
                                </div>
                            </div>
                      </div>
                      <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="note"></label>
                            <textarea class="form-control z-depth-1" id="note" name="note" rows="3" placeholder="Mettez une note..."><?= nl2br($note) ?></textarea>
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