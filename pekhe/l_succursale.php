<?php
session_start();

$_SESSION['id_user_dasil']="1";
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
		<title>Liste des clients</title>
		<?php include 'css.php'; ?>
	</head>
	<body id="debut" class="blue-grey lighten-5">
		<?php
		include 'verif_menu.php';
        ?>
        <br>
        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalSuccursaleForm">Nouvelle Succursale <i class="far fa-user ml-1"></i></a>
        </div>
        <div class="container mt-2">
            <div class="row">
                <h1 class="col-sm-12 text-center" ><b>Liste des succursales</b></h1>
                <div class="col-6 sm-4">
                    <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche"
                            aria-label="Search">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="card col-md-10 offset-md-1">
                    <div class="row table-responsive ">
                        <table class="table col-md-12  table-hover w-auto  card-body ml-3">
                            <thead class="">
                                <tr >
                                    <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                                    <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Nom</th>
                                    <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Emplacement</th>
                                    <th class="font-weight-bold text-center text-uppercase th-lg" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal: Succursale form -->
            <div class="modal fade" id="modalSuccursaleForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">

                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><i class="fas fa-user"></i> Nouvelle succursale</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="e_succursale_trmnt.php" >
                        <div class="row">
                            <div class="col-md-10 mb-4">
                                <div class="md-form">
                                    <input type="text" required name="nom" id="nom" class="form-control">
                                    <label for="nom" class="">Nom</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mb-4">
                                <div class="md-form">
                                    <input type="text" required id="localisation" name="localisation" class="form-control">
                                    <label for="localisation" class="">Localisation</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                        <button type="submit" class="btn blue-gradient">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Content -->
            </div>
            </div>
            <!-- Modal: client form -->
        </div>
        
    <span id="fin"></span>
    <?php include 'js.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            
            function l_client(search) {
				$.ajax({
					type:'POST',
					url:'l_succursale_ajax.php',
					data:'search='+search,
					success:function (html) {
						$('tbody').html(html);
					}
				});
			}

			var search ="";
			l_client(search);
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			l_client(search)
            });
            
        });
    </script>
	</body>
	<style type="text/css">

	</style>
</html>