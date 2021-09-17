<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$data = json_decode(file_get_contents('php://input'));

$queryStr = 'UPDATE produits SET nom_produits = :nom, prix_produits = :prix WHERE identifiant_produits = :identifiant';

$updateQuery = $bdd->connexion->prepare($queryStr);

$updateQuery->bindParam(':nom', $data->nom_produits, PDO::PARAM_STR);
$updateQuery->bindParam(':prix', $data->prix_produits, PDO::PARAM_INT);
$updateQuery->bindParam(':identifiant', $data->identifiant_produits, PDO::PARAM_INT);

$updateQuery->execute();

echo json_encode('Done');


?>