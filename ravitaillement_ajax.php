<?php
session_start();
include 'connexion.php';
$mois1 = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel1 = $mois1[date("n")];

$mois = $_POST['mois'];
$annee = $_POST['annee'];

$reponse = $db->prepare("SELECT id, CONCAT(DATE_FORMAT(date_ravitailement, '%d'), '/', DATE_FORMAT(date_ravitailement, '%m'),'/', DATE_FORMAT(date_ravitailement, '%Y')), `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `registre`, `arme`, `chargeur_arme`, `casque`, `smartphone`, `telephone_simple`, `miroir_telescopique`, `detecteur`, `chargeur_detecteur`, `gilet`, cravate, combinaison , `blouson`, `pantalon_parka`, `torche`
FROM `ravitaillement_art_gard` 
WHERE etat=1 AND YEAR(date_ravitailement)=? AND MONTH(date_ravitailement)=? ORDER BY date_ravitailement DESC");
$reponse->execute(array($annee, $mois));

$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
$total = 0;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_ravitaillement = $donnees['1'];
    $lacoste = $donnees['2'];
    $veste_normale = $donnees['3'];
    $veste_parka = $donnees['4'];
    $chaussure_ville = $donnees['5'];
    $chaussure_securite = $donnees['6'];
    $tonfa = $donnees['7'];
    $ceinturon = $donnees['8'];
    $epaulettes = $donnees['9'];
    $chemise = $donnees['10'];
    $pantalon_simple = $donnees['11'];
    $badge = $donnees['12'];
    $kepi = $donnees['13'];
    $casquette = $donnees['14'];
    $registre = $donnees['15'];
    $arme = $donnees['16'];
    $chargeur_arme = $donnees['17'];
    $casque = $donnees['18'];
    $smartphone = $donnees['19'];
    $telephone_simple = $donnees['20'];
    $miroir_telescopique = $donnees['21'];
    $detecteur = $donnees['22'];
    $chargeur_detecteur = $donnees['23'];
    $gilet = $donnees['24'];
    $cravate = $donnees['25'];
    $combinaison = $donnees['26'];
    $blouson = $donnees['27'];
    $pantalon_parka = $donnees['28'];
    $torche = $donnees['29'];

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_ravitaillement . "</td>";
    echo "<td class='text-center'>" . $lacoste . "</td>";
    echo "<td class='text-center'>" . $veste_normale . "</td>";
    echo "<td class='text-center'>" . $veste_parka . "</td>";
    echo "<td class='text-center'>" . $chaussure_ville . "</td>";
    echo "<td class='text-center'>" . $chaussure_securite . "</td>";
    echo "<td class='text-center'>" . $tonfa . "</td>";
    echo "<td class='text-center'>" . $ceinturon . "</td>";
    echo "<td class='text-center'>" . $epaulettes . "</td>";
    echo "<td class='text-center'>" . $chemise . "</td>";
    echo "<td class='text-center'>" . $pantalon_simple . "</td>";
    echo "<td class='text-center'>" . $badge . "</td>";
    echo "<td class='text-center'>" . $kepi . "</td>";
    echo "<td class='text-center'>" . $casquette . "</td>";
    echo "<td class='text-center'>" . $registre . "</td>";
    echo "<td class='text-center'>" . $arme . "</td>";
    echo "<td class='text-center'>" . $chargeur_arme . "</td>";
    echo "<td class='text-center'>" . $casque . "</td>";
    echo "<td class='text-center'>" . $smartphone . "</td>";
    echo "<td class='text-center'>" . $telephone_simple . "</td>";
    echo "<td class='text-center'>" . $miroir_telescopique . "</td>";
    echo "<td class='text-center'>" . $detecteur . "</td>";
    echo "<td class='text-center'>" . $chargeur_detecteur . "</td>";
    echo "<td class='text-center'>" . $gilet . "</td>";
    echo "<td class='text-center'>" . $cravate . "</td>";
    echo "<td class='text-center'>" . $combinaison . "</td>";
    echo "<td class='text-center'>" . $blouson . "</td>";
    echo "<td class='text-center'>" . $pantalon_parka . "</td>";
    echo "<td class='text-center'>" . $torche . "</td>";
    echo "<td class='text-center'>";
    echo '
            <td>
                
                <a href="m_ravitaillement.php?id=' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
                &nbsp&nbsp&nbsp<a href="s_ravitaillement.php?id=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer ce ravitaillement ?\'))" ><i class="fas fa-times"></i></a>
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
                        <h4 class=""><i class="fas fa-user"></i> Modification ravitaillement</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">

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


?>