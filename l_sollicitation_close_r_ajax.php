<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$id_commercial = $_POST['commercial'];


if ($id_commercial == "tous") {
    $id_commercials = " ";
} else {
    $id_commercials = " AND sollicitation.id_commercial=" . $id_commercial;
}
if ($search == "") {

    $reponse = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type,  CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y')),  CONCAT(DATE_FORMAT(sollicitation.date_depot, '%d'), '/', DATE_FORMAT(sollicitation.date_depot, '%m'),'/', DATE_FORMAT(sollicitation.date_depot, '%Y')), offre_financiere, marge, sollicitation.etat, CONCAT(user.prenom,' ', user.nom)
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    INNER JOIN user on user.id=sollicitation.id_commercial
    WHERE sollicitation.etat>2  " . $id_commercials . " AND MONTH(sollicitation.date_depot)=? AND YEAR(sollicitation.date_depot)=? ORDER BY sollicitation.date_depot DESC");
    $reponse->execute(array($mois, $annee));
} else {
    $reponse = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type,  CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y')),  CONCAT(DATE_FORMAT(sollicitation.date_depot, '%d'), '/', DATE_FORMAT(sollicitation.date_depot, '%m'),'/', DATE_FORMAT(sollicitation.date_depot, '%Y')), offre_financiere, marge, sollicitation.etat, CONCAT(user.prenom,' ', user.nom)
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    INNER JOIN user on user.id=sollicitation.id_commercial
    WHERE sollicitation.etat>2 AND CONCAT (client.client,' ',sollicitation.departement, ' ',sollicitation.details_ao) like CONCAT('%', ?, '%')  " . $id_commercials . " AND MONTH(sollicitation.date_depot)=? AND YEAR(sollicitation.date_depot)=? ORDER BY sollicitation.date_depot DESC");
    $reponse->execute(array($search, $mois, $annee));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucune sollicitation close</h3></td></tr>";
}
$i = 1;

while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_reception = $donnees['1'];
    $client = $donnees['2'];
    $departement = $donnees['3'];
    $detail_ao = $donnees['4'];
    $type_sollicitation = $donnees['5'];
    $date_limite = $donnees['6'];
    $date_depot = $donnees['7'];
    $offre_finaciere = $donnees['8'];
    $marge = $donnees['9'];
    $etat = $donnees['10'];
    $commercial = $donnees['11'];
    if ($etat == 3) {
        $etat = 'Abandonner';
        echo "<tr class='pink lighten-3'>";
    } else {
        $etat = 'Déposer';
        echo "<tr>";
    }

    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_depot . "</td>";
    echo "<td class='text-center'>" . $client . "</td>";
    echo "<td class='text-center'>" . $type_sollicitation . "</td>";
    echo "<td class='text-center'>" . $departement . "</td>";
    echo "<td class='text-center'>" . $date_limite . "</td>";
    echo "<td class='text-center'>" . $date_reception . "</td>";
    echo "<td class='text-center'>" . $offre_finaciere . "</td>";
    echo "<td class='text-center'>" . $marge . "</td>";
    echo "<td class='text-center'>" . $etat . "</td>";

    $req_doc = $db->prepare('SELECT document_sollicitation.nom_document, document_sollicitation.chemin FROM document_sollicitation WHERE document_sollicitation.id_sollicitation=?');
    $req_doc->execute((array($id)));
    echo '<td class="text-center">';
    while ($donnees_doc = $req_doc->fetch()) {
        echo '<a href="' . $donnees_doc[1] . '" class="blue-text" >' . $donnees_doc[0] . '</a><br>';
    }
    echo '</td">';
    echo "<td class='text-center'>" . $commercial . "</td>";
    echo '<td class="text-center"><a href="" class="btn btn-primary btn-rounded btn-sm" data-toggle="modal" data-target="#modalEtat' . $id . '">Détail(s)</a></td>';
    echo "<td class='text-center'>";
?>
    <!-- Modal: Succursale form -->
    <div class="modal fade" id="modalEtat<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><?= $type_sollicitation ?></h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="recup_sollicitation.php?id=<?= $id ?>">
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="details_ao"></label>
                                <textarea class="form-control z-depth-1" id="details_ao" name="details_ao" rows="3" placeholder="Commentaire"><?= $detail_ao ?></textarea>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Traiter</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Content -->
        </div>
    </div>
    <?php
    echo "</td>";

    $i++;

    ?>


<?php
    echo "</tr>";
}

?>
<script type="text/javascript">
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>