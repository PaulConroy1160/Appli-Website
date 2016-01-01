<?php

class employer {
    
    private $id;
    private $fName;
    private $lName;
    private $company;
    private $email;
    private $location;
    private $bio;
    private $photo;
    private $password;
    
    function __construct($i,$fn,$ln,$c,$e,$l,$b,$ph,$p) {
        $this->id = $i;
        $this->fName = $fn;
        $this->lName = $ln;
        $this->company = $c;
        $this->email = $e;
        $this->location = $l;
        $this->bio = $b;
        $this->photo = $ph;
        $this->password = $p;
    }
    
     /////////////////////////////
    //----------GET------------//
    /////////////////////////////
    public function getId(){
        return $this->id;
    }
    
    public function getFName(){
        return $this->fName;
    }
    
    public function getLName(){
        return $this->lName;
    }
    
    public function getCompany(){
        return $this->company;
    }
    
    public function getEmail(){
        return $this->email;
    }
        
    public function getPassword(){
        return $this->password;
    }
    
    public function getLocation(){
        return $this->location;
    }
    
    public function getBio(){
        return $this->bio;
    }
    
    public function getPhoto(){
        return $this->photo;
    }
    /////////////////////////////
    //----------SET------------//
    /////////////////////////////
    
    public function setId($i){
        $this->id = $i;
    }
    
    public function setFName($fn){
        $this->fName = $fn;
    }
    
    public function setLName($ln){
        $this->lName = $ln;
    }
    
    public function setCompany($c){
        $this->company = $c;
    }
    
    public function setEmail($e){
        $this->email = $e;
    }
    
    public function setPassword($p){
        $this->password = $p;
    }
    
    public function setLocation($l){
        $this->location = $l;
    }
    
    public function setBio($b){
        $this->location = $b;
    }
    
    public function setPhoto($p){
        $this->photo = $p;
    }
}