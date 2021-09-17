<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("./param/config.php");

$bdd = new Database;

$bdd->getConnexion();

$query = $bdd->connexion->query('SELECT * FROM commande ORDER BY id_item DESC');

$returnItem = $query->fetch();

$commandeListOrdonate = [];

$totalCommande = 0;

while($returnItem != null){
    if($returnItem['id_users'] != null){
        $userQuery = $bdd->connexion->query('SELECT * FROM users WHERE id_users = '.$returnItem['id_users'].'');
        $userInfo = $userQuery->fetch();
    }

    $productQuery = $bdd->connexion->query('SELECT * FROM produits WHERE id_produits = '.$returnItem['id_produits'].'');
    $productInfo = $productQuery->fetch();
    $productInfo['qte'] = $returnItem['qte'];
    $statutQuery = $bdd->connexion->query('SELECT * FROM statut_commande WHERE identifiant_commande = '.$returnItem['identifiant_commande'].'');
    $statutInfo = $statutQuery->fetch();

    /*if(isset($userInfo)) {
        $productInfo['userInfo'] = $userInfo;
    }*/

    if(isset($commandeListOrdonate[$returnItem['identifiant_commande']])) {
        array_push($commandeListOrdonate[$returnItem['identifiant_commande']], $productInfo);
        $commandeListOrdonate[$returnItem['identifiant_commande']]['total'] += ($productInfo['prix_produits'] * $returnItem['qte']);

        if(isset($userInfo)){  
            $commandeListOrdonate[$returnItem['identifiant_commande']]['userInfo'] = $userInfo;
        }
    }
    else{
        $commandeListOrdonate[$returnItem['identifiant_commande']]['0'] = $productInfo;
        $commandeListOrdonate[$returnItem['identifiant_commande']]['total'] = $productInfo['prix_produits'] * $returnItem['qte'];

        if(isset($userInfo)){  
            $commandeListOrdonate[$returnItem['identifiant_commande']]['userInfo'] = $userInfo;
        }
    }
    $commandeListOrdonate[$returnItem['identifiant_commande']]['statut'] = $statutInfo;
    $commandeListOrdonate[$returnItem['identifiant_commande']]['date'] = date('d/m/Y à H:i:s', $returnItem['identifiant_commande']);
    $returnItem = $query->fetch();
}

echo json_encode($commandeListOrdonate);

?>