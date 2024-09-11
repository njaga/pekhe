<?php
session_start();
include 'connexion.php';

if (isset($_POST['login']) && isset($_POST['pwd'])) 
{
	$login=htmlspecialchars($_POST['login']);
	$pwd=htmlspecialchars($_POST['pwd']);
}
else
{
	?>
	<script type="text/javascript">
		alert("Veuillez vérifier les informations saisies");
		window.history.go(-1);
	</script>
	<?php
}
	
$req=$db->prepare('SELECT user.`id`, user.`prenom`, user.`nom`, user.`profil`, user.`telephone`, user.`email`, user.`login`, user.`pwd`, user.id_employe, employe.id_departement, departement.nom, departement.id_manager, user.email
FROM `user`
INNER JOIN employe ON employe.id=user.id_employe 
INNER JOIN departement ON departement.id=employe.id_departement
WHERE login=? AND user.etat=1');
$req->execute(array($login));
$num_of_rows = $req->rowCount() ;
$donnees=$req->fetch();
if ($num_of_rows<1)
{
	?>
	<script type="text/javascript">
		alert("Mauvais identifiant ou mot de passe!");
		window.history.go(-1);
		
	</script>
	<?php
}
else
{
	if ($donnees['7']==sha1($_POST['pwd'])) 
	{
		$_SESSION['id_vigilus_user']=$donnees['0'];
		$_SESSION['prenon_vigilus_user']=$donnees['1'];
		$_SESSION['nom_vigilus_user']=$donnees['2'];
		$_SESSION['profil_vigilus_user']=$donnees['3'];
		$_SESSION['telephone_vigilus_user']=$donnees['4'];
		$_SESSION['email_vigilus_user']=$donnees['5'];
		$_SESSION['login_vigilus_user']=$donnees['6'];
		$_SESSION['id_employe']=$donnees['8'];
		$_SESSION['id_departement']=$donnees['9'];
		$_SESSION['nom_departement']=$donnees['10'];
		$_SESSION['id_manager_departement']=$donnees['11'];
		$_SESSION['user_email']=$donnees['12'];
		/*
		$_SESSION['departement_vigilus_user']=$donnees['0'];
		$_SESSION['succursale_vigilus_user']=$donnees['0'];
		*/
		$_SESSION['chemin_document']="documents/";
		header("location:accueil.php?a=a");
	}
	else
	{
		?>
		<script type="text/javascript">
			alert("Mauvais identifiant ou mot de passe !");
			window.history.go(-1);
		</script>
		<?php
	}
}
?>