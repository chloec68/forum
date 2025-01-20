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

    /* la méthode effectue une requête SQL qui récupère les valeurs de tous les champs d'un enregistrement
                                            dont la valeur de l'id doit être passée à la fonction
                                        En valeur de retour, elle appelle la méthode getOneOrNullResult sur un objet */
    
    public function findOneById($id){ 
        // construction de la requête
        $sql = "SELECT *
                FROM ".$this->tableName." a
                WHERE a.id_".$this->tableName." = :id
                ";
        // exécution de la requête et récupération du résultat
        return $this->getOneOrNullResult( /* La méthode getOneOrNullResult prend en entrée le résultat de la méthode DAO::select() et la classe à utiliser pour créer un objet
                                            Si la requête retourne des résultats, cette méthode crée un objet de type className = une classe représentant un enregistrement (une line)
                                            dans une table, par exemple User
                                            Le paramètre $row contient les données de l'enregistrement récupéré en BDD */
            DAO::select($sql, ['id' => $id], false), /*La méthode select() est appelée sur l'objet DAO. Elle exécute la requête SQL construite précédemment. 
                                                    Le tableau ['id' => $id] associe le paramètre :id dans la requête SQL à la valeur de $id passée à la méthode findOneById().
                                                    l'argument false car la requête doit renvoyer un seul résultat - voir méthode select du DAO */
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

   
    public function edit($id,$data){
        // $data est un tableau associatif qui contient les colonnes (les champs) et leurs valeurs à mettre à jour
        // $id est l'identifiant de l'enregistrement (la ligne) à mettre à jour 

        if(empty($data)){
            return false;
        }

        $setStatements = []; // initialisation d'un tableau vide destiné à stocker les expressions SQL de type clé=:clé

        foreach($data as $key => $value){ /*pour chaque clé et valeur du tableau $data, on ajoute une chaîne de type "clé = :clé" pour préparer 
                                            la requête parametrée */
            $setStatements[] = "$key = :$key";
        }

        $setQuery = implode(', ', $setStatements); /* on transforme $setStatements en une chaîne unique où les éléments sont séparés par des virgules, 
        car c'est le format SQL attendu dnas l'hypothèse où on souhaite pouvoir envoyer plusieurs valeurs:
        UPDATE table
        SET colonne_1 = 'valeur 1', colonne_2 = 'valeur 2', colonne_3 = 'valeur 3'
        WHERE condition */

        $sql = "UPDATE " . $this->tableName . " SET "." $setQuery WHERE id_" . $this->tableName . " = :id"; /* création requête SQL pour la mise à jour avec
        détermination dynamique de la table par l'usage de $this->tableName */

        // $setStatements[] = $id;
        $data['id'] = $id;
        // ajout de l'id au tableau pour le bind dans la requête SQL 
        /* les paramètres liés, aussi appelés paramètres dynamiques ou variables liées (bind parameters) permettent de passer des données à la BDD
        => au lieu de placer directement les valeurs dans la requête SQL, on utilise un marque ? ou :nom ou :@ */

        return DAO::update($sql,$data); // appel de la méthode update (DAO) qui exécute la requête préparée avec les données 

        /* MANQUE LA GESTION DES ERREUR AVEC TRY CATCH : en cas d'erreur, affiche le message d'erreur et arrête l'exécution du script */
    }
 


    public function delete($id){
        $sql = "DELETE FROM ".$this->tableName."
                WHERE id_".$this->tableName." = :id
                ";

        return DAO::delete($sql, ['id' => $id]); 
    }

    private function generate($rows, $class){ //Cette méthode fait le travail de transformation des résultats de la base de données (qui sont généralement des tableaux) en objets métiers (ou entités). 
        foreach($rows as $row){ // la méthode parcourt chaque ligne de données $row du tableau $rows 
            yield new $class($row); //mot-clé yield : plutôt que de retourner un tableau contenant tous les objets, yield renvoie un objet au fur et à mesure
            // qu'il est créé => génère les objets un par un => tous les objets ne sont pas créés en une seule fois => tous les objets ne sont pas renvoyés
            //en même temps => un nouvel objet est créé à chaque itération de la boucle
        }
    } // chaque ligne de la BDD est convertie en objet initié à partir de la class fournie dans le paramètre $class
    
    protected function getMultipleResults($rows, $class){
    //$rows : ce paramète représente leS résultatS d'une requête SQL (=>un objet itérable => un tableau => les données de la BDD)
    // $class : ce paramètre est la classe à laquelle chaque $row devra être "mappée" 

        if(is_iterable($rows)){ // vérifie s'il s'agit bien d'un objet itérable 
            return $this->generate($rows, $class); // si l'objet est itérable, appelle de la méthode generate ; chaque ligne de résultat $row est 
            // convertie en une instance de $class (si $class = Category => chaque $row devient un Objet new Category instancié à partir de la classe $Category)
        }
        else return null;
    }

    protected function getOneOrNullResult($row, $class){ /* $row représente les valeurs d'un enregistrement en bdd ; $class représente une entité/un objet => donc une table
        donc cette méthode prend en entrée le résultat de la méthode DAO::select() et la classe à utiliser pour créer un objet */

        if($row != null){
            return new $class($row);
        }
        return false;
    } /* si la requête retourne des résultats, la méthode crée un objet instancié à partir de la $class spécifiée et passe un argument au constructeur */

    protected function getSingleScalarResult($row){

        if($row != null){
            $value = array_values($row);
            return $value[0];
        }
        return false;
    }

}