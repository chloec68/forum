<?php

namespace Model\Entities;

use App\Entity;

final Class Post extends Entity{
    private $id;
    private $content;
    private $dateOfCreation; 
    private $topic;
    private $user;

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
     */

    public function setId($id){
        $this->id=$id;
        return $this;
    }

     /**
     * Get the value of text
     */ 

    public function getContent(){
        return $this->content;
    }

     /**
     * Set the value of text
     */

    public function setContent($content){
        $this->content=$content;
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
        $this->dateOfCreation=$dateOfCreation;
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
        $this->topic=$topic;
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
        $this->user=$user;
        return $this;   
    }


    public function __toString() {
        // Make sure to return a string representation of the object
        return $this->content . "<br>By: " . $this->user . ", posted on : " . $this->dateOfCreation ;
    }
}

