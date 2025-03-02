<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les posts d'un topic spécifique (par son id)
    public function findPostsByTopic($id) {

        $sql = "SELECT id_post, content, dateOfCreation, topic_id, user_id 
                FROM ".$this->tableName." t 
                WHERE t.topic_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function findPostsByUser($id){

        $sql = "SELECT t.id_post, t.content, t.dateOfCreation, t.topic_id, topic.title FROM " . $this->tableName . " t 
        INNER JOIN topic ON t.topic_id = topic.id_topic
        WHERE t.user_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id'=>$id]),
            $this->className
        );
    }

}