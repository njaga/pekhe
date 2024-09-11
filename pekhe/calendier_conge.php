<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des Demandes de Congés</title>

    <!-- Inclure la bibliothèque FullCalendar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <!-- Ajoutez ici vos autres liens vers les feuilles de style CSS si nécessaire -->
    <style>
        /* Couleurs spécifiques pour chaque employé */
        .employe1 {
            background-color: #3498db; /* Bleu */
            border-color: #3498db; /* Bordure Bleue */
            color: #fff; /* Texte Blanc */
        }

        .employe2 {
            background-color: #e74c3c; /* Rouge */
            border-color: #e74c3c; /* Bordure Rouge */
            color: #fff; /* Texte Blanc */
        }

        /* Ajoutez d'autres classes pour chaque employé si nécessaire */
    </style>
</head>
<body>

<div id="calendrier"></div>

<script>
    $(document).ready(function() {
        // Récupérer les données des demandes de congés (remplacez cette partie par la récupération réelle des données depuis votre base de données)
        var demandesConges = [
            { title: 'Congé 1', start: '2024-01-05', end: '2024-01-07', employe: 'Employe1' },
            { title: 'Congé 2', start: '2024-01-05', end: '2024-01-15', employe: 'Employe2' },
            // Ajoutez d'autres demandes de congés...
        ];

        // Initialiser le calendrier
        $('#calendrier').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: demandesConges,
            locale: 'fr', // Utiliser la localisation française
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour'
            },
            eventLimit: true, // Activer l'affichage de "plus d'événements" pour les jours chargés
            firstDay: 1, // Le premier jour de la semaine est lundi
            eventRender: function(event, element) {
                // Ajouter une classe spécifique pour chaque employé
                element.addClass(event.employe.toLowerCase());
            },
           
            eventClick: function(event) {
                // Gérer les clics sur un événement si nécessaire
                alert('Demande de congé : ' + event.title + ' pour l\'employé ' + event.employe);
            }
        });
    });
</script>

</body>
</html>
