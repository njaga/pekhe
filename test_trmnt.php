<?php
session_start();
include 'connexion.php';
$list_pj = $_POST['pj'];
foreach ($list_pj as $pj) {
    echo 'Element : ' . $pj . '
';
}
