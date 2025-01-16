<?php
namespace App; // permet de structurer le projet

/* La classe Manager fournit une abstraction pour interagir avec une base de données.
 Elle permet d'exécuter une requête SELECT * sur une table spécifique et de retourner les résultats sous forme d'objets.
 La méthode findAll permet de récupérer tous les enregistrements d'une table, avec un tri optionnel basé sur un champ et un ordre donné.
 Les classes qui étendent Manager doivent définir le nom de la table ($tableName) et la classe des objets à hydrater ($className).
 La gestion de la base de données est effectuée par la classe DAO, notamment pour la connexion et l'exécution des requêtes. */

abstract class Manager{ //classe ABSTRAITE Manager => cette classe ne peut pas être instanciée, elle doit être étendue par d'autres classes pour être utilisée 

    protected function connect(){ //méthode PROTEGEE => elle peut être utilisée dans cette classes et les classes qui en héritent (c'est tout)
        DAO::connect(); // appelle d'une méthode statique connect() sur la Classe DAO => on s'assure que connexion à BDD soit établie avant toute opération 
    }

    /**
     * get all the records of a table, sorted by optionnal field and order
     * 
     * @param array $order an array with field and order option
     * @return Collection a collection of objects hydrated by DAO, which are results of the request sent
     */

    // Cette méthode retourne une collection d'objets 
    // Les objets contiennent les résultats de la requête SQL 
    // Ces objets sont hydratés par la méthode getMultipleResults()
    // A partir des résultats renvoyés par la requête DAO::select($sql)
    public function findAll($order = null){ // méthode PUBLIQUE (appelable depuis partout dans le code) de la class Manager // cette classe prend un paramètre OPTIONNEL $order
                                            // la syntaxe $order = NULL signifie que l'argument est optionnel 
        $orderQuery = ($order) ?   // Si le paramètre optionnel $order est fourni, la méthode findAll construit une CLAUSE ORDER BY // si $order est null ou vide, clause non incluse dans requête               
            "ORDER BY ".$order[0]. " ".$order[1] :
            "";

        $sql = "SELECT * 
                FROM ".$this->tableName." a
                ".$orderQuery; // requête SQL dynamique car la table = $this->tableName => suppose que la classe qui ETEND Manager définit la propriété $tableName
                                // la variable $orderQuery contient la partie de la requête destinée à trier les résultats si elle est définie 

        return $this->getMultipleResults( //méthode (définie plus bas) appelée pour transformer résultats obtenus en objet de type className 
            DAO::select($sql), // appel de la méthode statique select de la Class DAO responsable de l'exécution de la requête 
            $this->className // les résultats bruts de la BDD pris
        );
    }
    
    public function findOneById($id){

        $sql = "SELECT *
                FROM ".$this->tableName." a
                WHERE a.id_".$this->tableName." = :id
                ";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), 
            $this->className
        );
    }

    //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];

    public function add($data){
        //$keys = ['username' , 'password', 'email']
        $keys = array_keys($data);
        //$values = ['Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com']
        $values = array_values($data);
        //"username,password,email"
        $sql = "INSERT INTO ".$this->tableName."
                (".implode(',', $keys).") 
                VALUES
                ('".implode("','",$values)."')";
                //"'Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com'"
        /*
            INSERT INTO user (username,password,email) VALUES ('Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com') 
        */
        try{
            return DAO::insert($sql);
        }
        catch(\PDOException $e){
            echo $e->getMessage();
            die();
        }
    }

        // *******************************************************************
        public function edit($id,$data){

            if(empty($data)){
                return false;
            }

            $setPart = [];

            foreach($data as $column => $value){
                $setPart[] = "$column = ?";
            }

            $setQuery = implode(', ', $setPart);

            $sql = "UPDATE " . $this->tableName . "SET $setQuery WHERE id_" . $this->tableName . " = ?";

            $params=array_values($data); // Récupérer les valeurs des données (en les convertissant en un tableau)
            $params[] = $id;

            return DAO::update($sql,$data);
        }
        // *******************************************************************


    public function delete($id){
        $sql = "DELETE FROM ".$this->tableName."
                WHERE id_".$this->tableName." = :id
                ";

        return DAO::delete($sql, ['id' => $id]); 
    }

    private function generate($rows, $class){ //Cette méthode fait le travail de transformation des résultats de la base de données (qui sont généralement des tableaux) en objets métiers (ou entités). 
        foreach($rows as $row){
            yield new $class($row);
        }
    } 
    
    protected function getMultipleResults($rows, $class){

        if(is_iterable($rows)){
            return $this->generate($rows, $class);
        }
        else return null;
    }

    protected function getOneOrNullResult($row, $class){

        if($row != null){
            return new $class($row);
        }
        return false;
    }

    protected function getSingleScalarResult($row){

        if($row != null){
            $value = array_values($row);
            return $value[0];
        }
        return false;
    }

}