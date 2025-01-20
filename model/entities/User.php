<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre,
    c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes,
    une classe finale ne peut pas être utilisée comme classe parente.

    classe finale en PHP permet de verrouiller une classe pour qu'elle ne puisse pas être étendue,
    ce qui peut améliorer la sécurité, l'intégrité du code et parfois les performances.
*/

final class User extends Entity{

    private $id;
    private $userName;
    private $password;
    // private $role;
    // private $email;
    // private $registrationDate;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of userName
     */ 
    public function getUserName(){
        return $this->userName;
    }

    /**
     * Set the value of userName
     *
     * @return  self
     */ 
    public function setUserName($userName){
        $this->userName = $userName;

        return $this;
    }
    

    public function __toString() {
        return $this->userName;
    }
}