<!DOCTYPE html>
<html>

<head>
    <title>Formulaire de choix jour/nuit</title>
</head>

<body>
    <form method="post" action="pl_trmnt.php">
        <h2>Choisissez le jour ou la nuit pour chaque jour du mois :</h2>

        <?php
        // Boucle pour générer les checkboxes pour les 30 jours du mois
        for ($jour = 1; $jour <= 30; $jour++) {
            echo "<label for='jour{$jour}'>Jour {$jour}</label>";
            echo "<input type='checkbox' name='jours[]' id='jour{$jour}' value='{$jour}'>";

            // Radio button pour le jour
            echo "<input type='radio' name='periode{$jour}' value='jour' id='jour{$jour}'> <label for='jour{$jour}'>Jour</label>";

            // Radio button caché pour la nuit
            echo "<input type='radio' name='periode{$jour}' value='nuit' id='nuit{$jour}' style=''> <label style='' for='nuit{$jour}'>Nuit</label><br>";
        }
        ?>

        <input type="submit" value="Soumettre">
    </form>
</body>

</html>