<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('./param/config.php');

$bdd = new Database;

$bdd->getConnexion();

$query = $bdd->connexion->query('SELECT * FROM produits ORDER BY id_categorie');

$retour = [];
$productFull = [];



$respond = $query->fetch();

    while($respond != null){

        $array = explode(';', $respond['id_ingredients']);

        foreach($array as $id) {
            $ingredientQuery = $bdd->connexion->query('SELECT * FROM ingredients WHERE id_ingredients = '.$id.'');
            $ingredientResult = $ingredientQuery->fetch();
            array_push($retour, $ingredientResult);
            $respond['id_ingredients'] = $retour; 
        }
        $retour = [];
        array_push($productFull, $respond);
        $respond = $query->fetch();
    }

    echo json_encode($productFull);

?>