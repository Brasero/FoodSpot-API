<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$data = json_decode(file_get_contents('php://input'));

$queryStr = "SELECT * FROM categories";

$query = $bdd->connexion->query($queryStr);

$respond = $query->fetchAll();

echo json_encode($respond);

?>