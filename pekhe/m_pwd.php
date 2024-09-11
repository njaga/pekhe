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
<html lang="Fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Modification mot de passe</title>
   <?php include 'css.php'; ?>
 
</head>
<body >
        <?php
		include 'verif_menu.php';
		?>
        <br>
        <br>
    <!-- Material form register -->
    <div class="container">
            <div class="row mt-5">
                <div class="col"></div>
                <div class="card col-5 pb-5 ">
                    <div class="card-block">
                        <form method="POST" action="m_pwd_trmnt.php">
                        <!--Header-->
                        <div class="form-header aqua-gradient py-3">
                            <h3 class="text-center"><i class="fa fa-user"></i> Modification mot passe</h3>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" id="ancien_password" name="ancien_password" class="form-control" required>
                            <label for="ancien_password">Ancien mot de passe</label>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                            <label for="new_password">Nouveau mot de passe</label>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            <label for="confirm_password">Confirmation mot de passe</label>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-indigo" type="submit">Enregistrer</button>
                            
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>

    <?php include'js.php'?>
  <script type="text/javascript">
    $(document).ready(function() {
        $('.mdb-select').materialSelect();
        $('#form').submit(function () {
            if (!confirm('Voulez-vous confirmer l\'enregistrement de cet étudiant ?')) {
                return false;
            }
        });
        });
  </script>

</body>
</html>
