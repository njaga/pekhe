<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];

if ($search == "") {

    $reponse = $db->query("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type, document_sollicitation.nom_document, document_sollicitation.chemin , CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y'))
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    LEFT JOIN document_sollicitation ON document_sollicitation.id_sollicitation=sollicitation.id
    WHERE sollicitation.etat=1");
} else {
    $reponse = $db->prepare("SELECT sollicitation.id, CONCAT(DATE_FORMAT(sollicitation.date_reception, '%d'), '/', DATE_FORMAT(sollicitation.date_reception, '%m'),'/', DATE_FORMAT(sollicitation.date_reception, '%Y')), client.client, sollicitation.departement, sollicitation.details_ao, sollicitation.type, document_sollicitation.nom_document, document_sollicitation.chemin, CONCAT(DATE_FORMAT(sollicitation.date_limit, '%d'), '/', DATE_FORMAT(sollicitation.date_limit, '%m'),'/', DATE_FORMAT(sollicitation.date_limit, '%Y'))
    FROM `sollicitation`
    INNER JOIN client ON client.id=sollicitation.id_client
    LEFT JOIN document_sollicitation ON document_sollicitation.id_sollicitation=sollicitation.id
    WHERE sollicitation.etat=1 AND CONCAT (client.client,' ',sollicitation.departement, ' ',sollicitation.details_ao) like CONCAT('%', ?, '%')");
    $reponse->execute(array($search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucune sollicitation en attente</h3></td></tr>";
}
$i = 1;

while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_reception = $donnees['1'];
    $client = $donnees['2'];
    $departement = $donnees['3'];
    $detail_ao = $donnees['4'];
    $type_sollicitation = $donnees['5'];
    $nom_doc = $donnees['6'];
    $chemin = $donnees['7'];
    $date_limite = $donnees['8'];
    if ($chemin != "") {
        $pj = '<a href="' . $chemin . '" class="btn btn-primary btn-rounded btn-sm" >PJ</a></td>';
    } else {
        $pj = "";
    }

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_reception . "</td>";
    echo "<td class='text-center'>" . $client . "</td>";
    echo "<td class='text-center'>" . $type_sollicitation . "</td>";
    echo "<td class='text-center'>" . $departement . "</td>";
    echo "<td class='text-center'>" . $date_limite . "</td>";
    echo '<td class="text-center"><a href="" class="btn btn-primary btn-rounded btn-sm" data-toggle="modal" data-target="#modalEtat' . $id . '">Détail(s)</a></td>';
    echo '<td class="text-center">' . $pj . '</td>';
    echo '<td class="text-center"><a href="recup_sollicitation.php?id=' . $id . '" class="btn btn-primary btn-rounded btn-sm">Traiter</a></td>';
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
                                <textarea disabled class="form-control z-depth-1" id="details_ao" name="details_ao" rows="3" placeholder="Commentaire"><?= $detail_ao ?></textarea>
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

    <!-- Modal: annuler -->
    <div class="modal fade" id="modalAnnuler<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <form method="POST" action="annuler_sollicitation.php?id=<?= $id ?>">
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="commentaire"></label>
                                <textarea class="form-control z-depth-1" id="commentaire" name="commentaire" rows="3" placeholder="Commentaire"></textarea>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn red white-text">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Content -->
        </div>
    </div>
    <?php
    echo "</td>";
    echo '
		<td>
			
			<a href="m_sollicitation.php?id=' . $id . '"  class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a><a href=""  data-toggle="modal" data-target="#modalAnnuler' . $id . '"><i class="fas fa-pencil-alt"></i></a>	
		</td>
		';

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