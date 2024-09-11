<?php
session_start();
include 'connexion.php';

$demandesConges="";
$req_ferier = $db->query("SELECT date_ferier, description FROM `jours_ferier` WHERE etat=1");
while ($donnees = $req_ferier->fetch()) {
    $date_ferier = $donnees['0'];
    $description = $donnees['1'];
    $demandesConges = $demandesConges.'{ title:"'.$description.'", start : "'.$date_ferier.'"},';
}



$reponse = $db->query("SELECT demande_conges.`id`,  
demande_conges.`date_debut`, demande_conges.`date_fin`, demande_conges.`motif`, type_conges.type_conges, employe.prenom, employe.nom
FROM `demande_conges` 
INNER JOIN employe ON employe.id=demande_conges.id_employe
INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
WHERE demande_conges.etat=3  
ORDER BY demande_conges.date_enregistrement DESC");

while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_debut = $donnees['1'];
    $date_fin = $donnees['2'];
    $motif = $donnees['3'];
    $type_conges = $donnees['4'];
    $prenom = $donnees['5'];
    $nom = $donnees['6'];
    $demandesConges = $demandesConges.'{ title:"'.$nom.'", start : "'.$date_debut.'", end : "'.$date_fin.'"},';
}
//echo $demandesConges;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des Demandes de Congés</title>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var demandesConges =  [<?= $demandesConges ?>]

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour'
                },
                initialView: 'multiMonthYear',
                multiMonthMaxColumns: 1, // force a single column
                initialDate: '2024-01-01',
                weekNumbers: true,
                locale: 'fr',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventLimit: true, // Activer l'affichage de "plus d'événements" pour les jours chargés
                firstDay: 1, // Le premier jour de la semaine est lundi
                events:demandesConges,
                eventColor: '#378006',
                eventDisplay:'block'
            });

            calendar.render();
        });
    </script>
</head>

<body>

    <div id='calendar'></div>


</body>

</html>