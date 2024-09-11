<?php
// Set the timezone
$timezone = new DateTimeZone('Europe/Paris');

$mois = 9; // Le mois à afficher
$annee = 2023; // L'année à afficher

$date = new DateTime("$annee-$mois-01");

// Afficher les jours du mois
for ($i = 1; $i <= $date->format('t'); $i++) {
    $datetime = new DateTime("$annee-$mois-$i", $timezone);
    $day_of_week = $datetime->format('l');
    echo $i . " " . $day_of_week . " <br>";
    //echo "Today is $day_of_week.";
}



// Get the day of the week

// Print the day of the week
