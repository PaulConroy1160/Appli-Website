<?php

class seeker {
    
    private $id;
    private $fName;
    private $lName;
    private $dob;
    private $email;
    private $password;
    private $location;
    private $experience;
    private $education;
    private $bio;
    private $theme;
    private $picture;
    
    function __construct($i,$fn,$ln,$d,$e,$p,$l,$ex,$ed,$b,$t,$pi) {
        $this->id = $i;
        $this->fName = $fn;
        $this->lName = $ln;
        $this->dob = $d;
        $this->email = $e;
        $this->password = $p;
        $this->location = $l;
        $this->experience = $ex;
        $this->education = $ed;
        $this->bio = $b;
        $this->theme = $t;
        $this->picture = $pi;
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
    
    public function getDOB(){
        return $this->dob;
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
    
    public function getExperience(){
        return $this->experience;
    }
    
    public function getEducation(){
        return $this->education;
    }
    
    public function getBio(){
        return $this->bio;
    }
   
    public function getTheme(){
        return $this->theme;
    }
    
    public function getPicture(){
        return $this->picture;
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
    
    public function setDOB($dob){
        $this->dob = $dob;
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
    
    public function setExperience($ex){
        $this->experience = $ex;
    }
    
    public function setEducation($ed){
        $this->education = $ed;
    }
    
    public function setBio($b){
        $this->bio = $b;
    }
    
    public function setTheme($t){
        $this->theme = $t;
    }
    
    public function setPicture($pi){
        $this->picture = $pi;
    }
    
}
?>
