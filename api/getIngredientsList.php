<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('./param/config.php');

$bdd = new Database;

$bdd->getConnexion();

$query = $bdd->connexion->query("SELECT * FROM ingredients");

$ingredients = $query->fetchAll();

echo json_encode($ingredients);

?>