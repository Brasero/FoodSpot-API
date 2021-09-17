<?php  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$timestamp = time();

$data = json_decode(file_get_contents('php://input'));

$bdd->getConnexion();

$queryStrID = 'INSERT INTO commande (identifiant_commande, id_users, id_produits, qte) VALUES (:identifiant_commande, :id_users, :id_produits, :qte)';
$queryStr = 'INSERT INTO commande (identifiant_commande, id_produits, qte) VALUES (:identifiant_commande, :id_produits, :qte)';

$queryStatutInsert = $bdd->connexion->query('INSERT INTO statut_commande (identifiant_commande, statut_commande_value) VALUES ('.$timestamp.', 0)');


if($data[1] != null) {
    foreach($data[0] as $products){
        $insertQuery = $bdd->connexion->prepare($queryStrID);

        $insertQuery->bindParam(':identifiant_commande', $timestamp, PDO::PARAM_INT);
        $insertQuery->bindParam(':id_users', $data[1], PDO::PARAM_INT);
        $insertQuery->bindParam(':id_produits', $products->id_produits, PDO::PARAM_INT);
        $insertQuery->bindParam(':qte', $products->qte_produits, PDO::PARAM_INT);
        
        $insertQuery->execute();

        var_dump($insertQuery->errorInfo());

    }
}
else {
    foreach($data[0] as $products){
        $insertQuery = $bdd->connexion->prepare($queryStr);

        $insertQuery->bindParam(':identifiant_commande', $timestamp, PDO::PARAM_INT);
        $insertQuery->bindParam(':id_produits', $products->id_produits, PDO::PARAM_INT);
        $insertQuery->bindParam(':qte', $products->qte_produits, PDO::PARAM_INT);
        echo json_encode($insertQuery->execute());
    }
}

?>