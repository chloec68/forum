<?php
namespace App;

/**
 * Classe d'accès aux données de la BDD, abstraite
 * 
 * @property static $bdd l'instance de PDO que la classe stockera lorsque connect() sera appelé
 *
 * @method static connect() connexion à la BDD
 * @method static insert() requètes d'insertion dans la BDD
 * @method static select() requètes de sélection
 * @method static update()
 * @method static delete()
 */

//  La méthode est statique, ce qui signifie qu'elle peut être appelée directement sur la classe sans avoir besoin de créer une instance de celle-ci.


abstract class DAO{
    /* attribut privé et statique $host auquel la valeur assignée est l'adresse du serveur MySql
    static => attribut partagé par toutes les instances de la classe DAO 
    => on veut une seule connexion à la BDD partagée dans toute l'application */
    private static $host   = 'mysql:host=127.0.0.1;port=8889'; //   mysql:host=127.0.0.1;port=3306
    private static $dbname = 'forum_chloe';
    private static $dbuser = 'root';
    private static $dbpass = 'root';

    private static $bdd;
                        /* l'idée de base avec DAO (Data Access Object) est de séparer la logique métier (=traitement des données) de 
                        la gestion des interactions avec la BDD */

    /**
     * cette méthode permet de créer l'unique instance de PDO de l'application
     */
    public static function connect(){
        
        self::$bdd = new \PDO(
            self::$host.';dbname='.self::$dbname, // ::self fait référence à la classe ; $this-> fait référence à l'instance d'une classe 
            self::$dbuser,
            self::$dbpass,
            array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            )   
        );
    }

    public static function insert($sql){
        try{
            // self::$bdd fait référence à l'instance de PDO stockée dans l'attribut statique $bdd de la classe DAO 
            $stmt = self::$bdd->prepare($sql); //$stmt est une variable locale et temporaire de la méthode insert() => contrairement aux attributs de la classe, elle ne perdure pas
            // dans toute la classe = > la variable ne peut pas être utilisée dans une autre méthode si elle n'y est pas définie 
            $stmt->execute();
            /*on renvoie l'id de l'enregistrement qui vient d'être ajouté en base, 
            pour s'en servir aussitôt dans le controleur*/
            return self::$bdd->lastInsertId();
            
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    }



    /* 
    EXEMPLE D'UTILISATION DE LA METHODE STATIQUE UPDATE : 

    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $params = ['John Doe', 'john@example.com', 1];

    $result = YourClass::update($sql, $params);

    name = ? et email = ? : Ces ? sont des marqueurs de paramètres. Lors de l'exécution de la requête préparée avec execute($params),
    les valeurs contenues dans le tableau $params seront utilisées pour remplacer ces marqueurs de paramètres.

    */

    public static function update($sql, $params){
        try{
            $stmt = self::$bdd->prepare($sql);
            
            //on renvoie l'état du statement après exécution (true ou false)
            return $stmt->execute($params);
            
        }
        catch(\Exception $e){
            
            echo $e->getMessage();
        }
    }
    
    public static function delete($sql, $params){
        try{
            $stmt = self::$bdd->prepare($sql);
            
            //on renvoie l'état du statement après exécution (true ou false)
            return $stmt->execute($params);
            
        }
        catch(\Exception $e){
            echo $sql;
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Cette méthode permet les requêtes de type SELECT
     * 
     * @param string $sql la chaine de caractère contenant la requête elle-même
     * @param mixed $params=null les paramètres de la requête
     * @param bool $multiple=true vrai si le résultat est composé de plusieurs enregistrements (défaut), false si un seul résultat doit être récupéré
     * 
     * @return array|null les enregistrements en FETCH_ASSOC ou null si aucun résultat
     */
    public static function select($sql, $params = null, bool $multiple = true):?array
    {
        try{
            $stmt = self::$bdd->prepare($sql);
            $stmt->execute($params);
            
            $results = ($multiple) ? $stmt->fetchAll() : $stmt->fetch();

            $stmt->closeCursor();
            return ($results == false) ? null : $results;
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}