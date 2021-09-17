<?php  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('./param/config.php');

$retour = [];
$productFull = [];

$bdd = new Database;

$bdd->getConnexion();

$instance = $bdd->connexion->prepare("SELECT * FROM produits WHERE id_categorie = :cat");

$cat = json_decode(file_get_contents('php://input'));

$instance->bindParam(':cat', $cat, PDO::PARAM_INT);

if($instance->execute()) {
    $respond = $instance->fetch();

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
        $respond = $instance->fetch();
    }

    echo json_encode($productFull);
    
}
else{
    echo json_encode("fail");
}


?>