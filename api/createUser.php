<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$matchQuery = $bdd->connexion->query("SELECT * FROM users");

$matchResult = $matchQuery->fetchAll();

$data = json_decode(file_get_contents("php://input"));

foreach($matchResult as $bddData){
    if($data->mail == $bddData['mail_users']){

        $actionReturn = false;
        break;

    }
    else{

        $actionReturn = true;

    }
}


if($actionReturn){
    $identifiant = time();


    $queryStr = "INSERT INTO users (identifiant_users, mail_users, nom_users, prenom_users, adresse_users, tel_users, mdp_users)
                 VALUES (:identifiant, :mail, :nom, :prenom, :adresse, :tel, :mdp)";

    $insertAction = $bdd->connexion->prepare($queryStr);

    $insertAction->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
    $insertAction->bindParam(':mail', $data->mail, PDO::PARAM_STR);
    $insertAction->bindParam(':nom', $data->nom, PDO::PARAM_STR);
    $insertAction->bindParam(':prenom', $data->prenom, PDO::PARAM_STR);
    $insertAction->bindParam(':adresse', $data->adresse, PDO::PARAM_STR);
    $insertAction->bindParam(':tel', $data->tel, PDO::PARAM_INT);
    $insertAction->bindParam(':mdp', $data->mdp, PDO::PARAM_STR);

    if($insertAction->execute()){
        echo json_encode("Compte créé");
    }
    else{
        echo json_encode("Une erreur est survenue lors de la tentative de création, veuillez réessayer.");
    }
}
else{
    echo json_encode("Cette adresse mail est déjà utilisé.");
}

?>