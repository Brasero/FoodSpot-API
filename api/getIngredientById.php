<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('./param/config.php');

$ingredients;

$bdd = new Database;

$bdd->getConnexion();

$data = json_decode(file_get_contents("php://input"));





$query = $bdd->connexion->prepare("SELECT * FROM ingredients WHERE id_ingredients = :id");

$query->bindParam(':id', $data, PDO::PARAM_INT);

$query->execute();

$retour = $query->fetch();

echo json_encode($retour);

?>