<?php  

class Database
{
    private $_host= "localhost";
    private $_dbName= "foodspot";
    private $_char= "utf8";
    private $_user= "root";
    private $_mdp= "";
    public $connexion;

    public function getConnexion(){

        $this->connexion = null;

        try{
            $this->connexion = new PDO('mysql:host='.$this->_host.';dbname='.$this->_dbName.';charset='.$this->_char, $this->_user, $this->_mdp);
        }
        catch(PDOException $error){

            echo 'Erreur de connexion à la base de données : '.$error->getMessage();

        }
    }

}

?>