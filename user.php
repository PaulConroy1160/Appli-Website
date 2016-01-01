<?php

class user {
    
    private $id;
    private $fName;
    private $lName;
    private $email;
    private $password;
    
    public function __construct($i, $fn, $ln, $e, $p) {
        $this->id = $i;
        $this->fName = $fn;
        $this->lName = $ln;
        $this->password = $p;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getFName(){
        return $this->fName;
    }
    
    public function getLName(){
        return $this->lName;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getPassword(){
        return $this->password;
    }
}
?>
