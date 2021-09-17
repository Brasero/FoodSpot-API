<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$dataEnter = json_decode(file_get_contents("php://input"));

$updateQueryStr = "UPDATE statut_commande SET statut_commande_value = 2 WHERE identifiant_commande = :id";

$updateQuery = $bdd->connexion->prepare($updateQueryStr);

$updateQuery->bindParam(':id', $dataEnter, PDO::PARAM_INT);

$updateQuery->execute();

echo json_encode($dataEnter);

?>