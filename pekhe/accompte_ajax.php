<?php
session_start();
include 'connexion.php';
$mois1 = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel1 = $mois1[date("n")];

$req_employe = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom, site.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN affectation_site ON affectation_site.id_employe=employe.id
INNER JOIN site ON affectation_site.id_site=site.id
WHERE departement.id=3 AND employe.etat=1 AND affectation_site.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");

$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
if ($search == "") {
    $reponse = $db->prepare("SELECT accompte.id, CONCAT(DATE_FORMAT(date_demande, '%d'), '/', DATE_FORMAT(date_demande, '%m'),'/', DATE_FORMAT(date_demande, '%Y')), CONCAT(employe.prenom, ' ', employe.nom), accompte.montant, accompte.etat, accompte.date_demande, employe.id, accompte.mois, employe.telephone, site.nom
    FROM `accompte` 
    INNER JOIN employe ON employe.id=accompte.id_employe
    INNER JOIN affectation_site ON employe.id=affectation_site.id_employe
    INNER JOIN site ON affectation_site.id_site=site.id
    WHERE affectation_site.etat=1 AND accompte.etat>0 AND mois=? AND YEAR(date_demande)=?
    ORDER BY date_demande DESC");
    $reponse->execute(array($mois, $annee));
} else {
    $reponse = $db->prepare("SELECT accompte.id, CONCAT(DATE_FORMAT(date_demande, '%d'), '/', DATE_FORMAT(date_demande, '%m'),'/', DATE_FORMAT(date_demande, '%Y')), CONCAT(employe.prenom, ' ', employe.nom), accompte.montant, accompte.etat, accompte.date_demande, employe.id, accompte.mois, employe.telephone, site.nom
    FROM `accompte` 
    INNER JOIN employe ON employe.id=accompte.id_employe
    INNER JOIN affectation_site ON employe.id=affectation_site.id_employe
    INNER JOIN site ON affectation_site.id_site=site.id
    WHERE affectation_site.etat=1 AND accompte.etat>0 AND mois=? AND YEAR(date_demande)=? AND CONCAT(employe.prenom, ' ', employe.nom) like CONCAT('%', ?, '%')
    ORDER BY date_demande DESC");
    $reponse->execute(array($mois, $annee, $search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
$total = 0;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_demande_texte = $donnees['1'];
    $employe = $donnees['2'];
    $montant = $donnees['3'];
    $etat = $donnees['4'];
    $date_demande = $donnees['5'];
    $id_employe = $donnees['6'];
    $mois_demande = $donnees['7'];
    $telephone = $donnees['8'];
    $site = $donnees['9'];
    $total = $total + $montant;
    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_demande_texte . "</td>";
    echo "<td class='text-center'>" . $employe . "</td>";
    echo "<td class='text-center'>" . $telephone . "</td>";
    echo "<td class='text-center'>" . $site . "</td>";
    echo "<td class='text-center'>" . $montant . "</td>";
    echo "<td class='text-center'>";
    if ($etat == "1") {
        echo "En cours...";
    } elseif ($etat == "2") {
        echo "Valider";
    } elseif ($etat == "3") {
        echo "Refuser";
    }
    if ($etat == "1" AND $_SESSION['profil_vigilus_user']=="comptabilite") {
        echo'
		<td>
        <a href="accepter_acc.php?id="'.$id.'" class="btn btn-success btn-sm"><i class="fas fa-check mr-2"></i>Accepter</a>
        </td>';
        echo'
		<td>
        <a href="refuser_acc.php?id="'.$id.'" class="btn btn-danger btn-sm"><i class="fas fa-times mr-2"></i>Refuser</a>
        </td>';
    }    
        
        
        
        echo '
            <td>
                
                <a href="" data-toggle="modal" data-target="#modalModifSite' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
                &nbsp&nbsp&nbsp
                <a href="s_accompte.php?s=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cet accompte ?\'))"><i class="fas fa-times"></i></a>
                &nbsp&nbsp&nbsp
                
            </td>';

    

    $i++;

?>
    <td>
        <!-- Modal: modif site -->
        <div class="modal fade" id="modalModifSite<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-user"></i> Modification accompte</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="m_accompte_trmnt.php">
                            <input type="number" name="id" value="<?= $id ?>" hidden>
                            <div class="row">
                                <div class="col-md-5  col-sm-8">
                                    <div class="md-form">
                                        <input type="date" id="date_demande" name="date_demande" class="form-control " value="<?= $donnees['5'] ?>" required>
                                        <label for="date_demande" class="active">Date demande</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8  col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="demandeur" disabled   name="demandeur" class="form-control " value="<?= $employe ?>" >
                                        <label for="demandeur" class="active">Demandeur</label>
                                    </div>
                                </div>
                                <div class="col-5 col-md-3 ">
                                    <select class="browser-default custom-select md-form" name="mois_demande" required="">
                                        <option selected>Sélectionnez le mois </option>
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) {
                                            echo "<option value='$i'";
                                            if ($i == $mois_demande) {
                                                echo "selected";
                                            }
                                            echo ">$mois1[$i]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" id="montant" value="<?= $montant ?>" name="montant" class="form-control" required>
                                        <label for="montant" class="active">Montant accompte</label>
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
    </td>
<?php
    echo "</tr>";
}
echo "<tr>";
    echo "<td colspan='5' class='text-center'><h3>TOTAL</h3></td>";
    echo "<td colspan='1' class='text-center'><h3>".number_format($total,0,'.',' ')."</h3></td>";
echo "</tr>";

?>
<script type="text/javascript">
     //$('.mdb-select').materialSelect();
</script>