<?php
session_start();
include 'connexion.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Choix du gardient pour une affectation</title>
		<?php include 'css.php';?>
	</head>
	<body style="background-image: url(<?=$image?>azsds.jpg);" >
		<?php
		include 'verif_menu.php';
		?>
            
        <div class="container-fluid">
            <!-- Section: liste employe -->
            <section class="mb-5">

                <!-- Card -->
                <div class="row">
                    <a href="e_employe.php" class="btn col-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
                </div>
                <div class="row">
                    
                    <div class="card card-cascade narrower col-md-10 offset-md-1">
                        
                        <div class="view view-cascade gradient-card-header blue-gradient">
                            <h1 class="mb-0">Choix du gardient pour une affectation</h1>
                        </div>
                        <!-- Card content -->
                        <div class="card-body card-body-cascade text-center table-responsive">
                                <div class="col-6 sm-4">
                                    <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                        <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche"
                                            aria-label="Search">
                                    </form>
                                </div>
                                <table class="table table-hover " id="l_employe">
                                    <thead class="black " >
                                       <tr >
                                           <td class="white-text">#</td>
                                           <td class="white-text">Matricule</td>
                                           <td class="white-text">Prénom</td>
                                           <td class="white-text">Nom</td>
                                           <td class="white-text">Dale et lieu naissance</td>
                                           <td class="white-text">Situation matrimoniale</td>
                                           <td class="white-text">Adresse</td>
                                           <td class="white-text">Site actuel</td>
                                           <td class="white-text"></td>
                                       </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    </tbody>
                                </table>
                        </div>
                        <!-- Card content -->

                    </div>
                </div>
                <!-- Card -->

            </section>
            <!-- Section -->
        </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
 
	</body>
	<style type="text/css">
		body
		{
			background-position: center center;
			background-repeat:  no-repeat;
			background-attachment: fixed;
			background-size:  cover;
			background-color: #999;
		}
		table{
			font-family: "times new roman";
		}
       
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
            function l_client(search) {
				$.ajax({
					type:'POST',
					url:'l_affectation_employe_ajax.php',
					data:'search='+search,
					success:function (html) {
						$('.tbody').html(html);
					}
				});
			}

			var search ="";
			l_client(search);
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			l_client(search)
            });
            
		})
	</script>
</html>