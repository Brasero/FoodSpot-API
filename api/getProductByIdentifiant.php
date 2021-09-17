<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('./param/config.php');

$bdd = new Database;

$bdd->getConnexion();

$identifiant = json_decode(file_get_contents('php://input'));

$selectQueryStr = 'SELECT * FROM produits WHERE identifiant_produits = :identifiant';

$selectQuery = $bdd->connexion->prepare($selectQueryStr);

$selectQuery->bindParam(':identifiant', $identifiant, PDO::PARAM_INT);

$selectQuery->execute();

$productReturn = $selectQuery->fetch();

echo json_encode($productReturn);

?>