<?php

namespace App\Models\Entity;

/**
 * @Entity @Table(name="users")
 **/
class User {

    /**
     * @var int
     * @Id @Column(type="integer") 
     * @GeneratedValue
     */
    public $id;

    /**
     * @var string
     * @Column(type="string") 
     */
    public $name;

    /**
     * @var string
     * @Column(type="string") 
     */
    public $password;


    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
        return $this;  
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
}