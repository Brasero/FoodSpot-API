<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$data = json_decode(file_get_contents("php://input"));

$queryStr = "SELECT * FROM users WHERE mail_users = :mail";

$queryUser = $bdd->connexion->prepare($queryStr);

$queryUser->bindParam(':mail', $data->mail, PDO::PARAM_STR);

if($queryUser->execute()){
    $queryResult = $queryUser->fetch();


    if($queryResult['mdp_users'] == $data->mdp){

        echo json_encode($queryResult);

    }
    else{
        echo json_encode("Le mot de passe ne correspond pas.");
    }
}
else{
    echo json_encode("Adresse mail inconnue");
}




?>