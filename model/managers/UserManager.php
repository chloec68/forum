<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    // ************************************************

    public function findUser($email){
        $sql = "SELECT * FROM user WHERE email = :email"; 
        return $this->getOneOrNullResult(DAO::select($sql,['email'=>$email]),
        $this->className);
    }

    public function insertUser($user){
        $sql = "INSERT INTO" . $this->tableName . "(userName,email,password) VALUES (':userName',':email',':password')" ; 
        return $this->add(DAO::insert($sql,["userName"=>$userName,"email"=>$email,"password"=>$password]),
        $this->className); 
    }
}

