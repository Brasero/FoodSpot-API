<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$data = json_decode(file_get_contents('php://input'));

$id = time();

$queryStr = 'INSERT INTO produits (identifiant_produits, nom_produits, prix_produits, id_categorie, id_ingredients, dispo_produits, img_produits) 
VALUES (:identifiant, :nom, :prix, :cat, :ingredient, 1, null)';

$listProduitsQuery = $bdd->connexion->query('SELECT * FROM produits');

$listProduits = $listProduitsQuery->fetchAll();

foreach($listProduits as $produit){
    if($data->nom_produits == $produit['nom_produits']) {

        $checkResult = false;
        break;

    }
    else {

        $checkResult = true;

    }
}

if($checkResult){

    $insertQuery = $bdd->connexion->prepare($queryStr);

    $insertQuery->bindParam(':identifiant', $id, PDO::PARAM_INT);
    $insertQuery->bindParam(':nom', $data->nom_produits, PDO::PARAM_STR);
    $insertQuery->bindParam(':prix', intval($data->prix_produits), PDO::PARAM_INT);
    $insertQuery->bindParam(':cat', $data->id_categorie, PDO::PARAM_INT);
    $insertQuery->bindParam(':ingredient', $data->ingredient, PDO::PARAM_STR);

    if($insertQuery->execute()) {
   
        $listProduitsQuery = $bdd->connexion->query('SELECT * FROM produits ORDER BY id_categorie');
        
        $retour = [];
        $productFull = [];

        $respond = $listProduitsQuery->fetch();

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
            $respond = $listProduitsQuery->fetch();
        }

        echo json_encode($productFull);

    }
}


?>