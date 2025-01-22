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
    private $role;
    private $email;
    private $registrationDate;
    private $avatar;

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

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
        return $this;
    }


    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($email){
        $this->email=$email;
        return $this;
    }

    public function getRole(){
        return $this->role;
    }

    public function setRole($role){
        $this->role=$role;
        return $this;
    }

    public function hasRole($role){
        if ($this->role !== "user"){
            return true;
        }else{
            return false;
        }
    }

    public function getRegistrationDate(){
        return $this->registrationDate;
    }

    public function setRegistrationDate($registrationDate){
        $this->registrationDate = $registrationDate;
        return $this;
    }

    public function getAvatar(){
        return $this->avatar;
    }

    public function setAvatar($avatar){
        $this->avatar=$avatar;
        return $this;
    }

    public function __toString() {
        return $this->userName;
    }
}