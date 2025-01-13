<?php

namespace Model\Entities;

use App\Entity;

final Class Post extends Entity{
    private $id;
    private $text;
    private $dateOfCreation; 
    private $topic;
    private $user;

    private function __construct($data){
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
     */

    public function setId($id){
        $this->id;
        return $this;
    }

     /**
     * Get the value of text
     */ 

    public function getText(){
        return $this->text;
    }

     /**
     * Set the value of text
     */

    public function setText($text){
        $this->text;
        return $this;
    }

     /**
     * Get the value of date
     */ 

    public function getDateOfCreation(){
        return $this->dateOfCreation;
    }

     /**
     * Set the value of date
     */

    public function setDateOfCreation($dateOfCreation){
        $this->dateOfCreation;
        return $this;
    }

     /**
     * Get the value of topic
     */ 

    public function getTopic(){
        return $this->topic;
    }

     /**
     * Set the value of topic
     */

    public function setTopic($topic){
        $this->topic;
        return $this;
    }

     /**
     * Get the value of user
     */ 

    public function getUser(){
        return $this->user;
    }

     /**
     * Set the value of user
     */

    public function setUser($user){
        $this->user;
        return $this;   
    }
}