<?php  

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$data = json_decode(file_get_contents("php://input"));

$queryStr = "UPDATE users SET mail_users = :mail, nom_users = :nom, prenom_users = :prenom, tel_users = :tel, adresse_users = :adresse WHERE id_users = :id";

$queryUpdate = $bdd->connexion->prepare($queryStr);

$queryUpdate->bindParam(':mail', $data->mail_users, PDO::PARAM_STR);
$queryUpdate->bindParam(':nom', $data->nom_users, PDO::PARAM_STR);
$queryUpdate->bindParam(':prenom', $data->prenom_users, PDO::PARAM_STR);
$queryUpdate->bindParam(':tel', $data->tel_users, PDO::PARAM_STR);
$queryUpdate->bindParam(':adresse', $data->adresse_users, PDO::PARAM_STR);
$queryUpdate->bindParam(':id', $data->id_users, PDO::PARAM_INT);

if($queryUpdate->execute()){
    echo json_encode("true");
}
else{
    echo json_encode($queryUpdate->execute());
    echo json_encode($data);
}

?>