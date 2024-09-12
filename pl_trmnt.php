<?php
// Vérification que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $joursChoisis = isset($_POST["jours"]) ? $_POST["jours"] : [];

    // Tableau associatif pour stocker les choix "Jour" ou "Nuit" pour chaque jour
    $choixPeriode = [];

    // Boucle pour récupérer les choix pour chaque jour
    foreach ($joursChoisis as $jour) {
        // Récupérer la valeur du radio button correspondant au jour
        $periode = isset($_POST["periode" . $jour]) ? $_POST["periode" . $jour] : "";

        // Stocker le choix dans le tableau associatif
        $choixPeriode[$jour] = $periode;
    }

    // Afficher les choix pour chaque jour
    echo "<h2>Vos choix :</h2>";
    foreach ($choixPeriode as $jour => $periode) {
        echo "Jour $jour : $periode<br>";
    }
} else {
    // Redirection en cas d'accès direct à cette page sans soumission du formulaire
    header("Location: index.php"); // Remplacez "index.php" par la page d'accueil de votre site
    exit;
}
