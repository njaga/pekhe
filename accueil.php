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

?>
<!DOCTYPE html>
<html>

<head>
  <title>Accueil</title>
  <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>2021_Januari_65.jpg);">
  <?php
  include 'verif_menu.php';
  ?>
  <div class="container">
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
      <!-- Position it -->
      <div style="position: absolute; top: 0; right: 0;">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
          <div class="toast-header">

            <strong class="mr-auto ">Bienvenue</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            <?= $_SESSION['prenon_vigilus_user'] . " " . $_SESSION['nom_vigilus_user'] ?>
          </div>
        </div>
      </div>
      <span id="fin"></span>
      <?php include 'footer.php'; ?>
      <?php include 'js.php'; ?>
      <script type="text/javascript">
        $(document).ready(function() {
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