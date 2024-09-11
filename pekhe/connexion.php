<?php
try {
	$db = new PDO('mysql:host=localhost;dbname=pekhe;charset=UTF8', 'root', '');
} catch (Exception $e) {
	echo "Erreur " . $e->getMessage();
}
$db->query("SET lc_time_names = 'fr_FR';");
