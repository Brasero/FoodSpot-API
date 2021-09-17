<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$identifiantCommande = json_decode(file_get_contents('php://input'));

$updateQueryStr = 'UPDATE statut_commande SET statut_commande_value = 1 WHERE identifiant_commande = :id';

$updateQuery = $bdd->connexion->prepare($updateQueryStr);

$updateQuery->bindParam(':id', $identifiantCommande, PDO::PARAM_INT);

$updateQuery->execute();

var_dump($updateQuery->errorInfo());

echo json_encode($identifiantCommande);

?>