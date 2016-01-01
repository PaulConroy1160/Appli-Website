<?php

//JobSave class
class jobSave{
    
    private $id;
    private $sId;
    private $jId;
    private $status;
    private $date;
    
    //jobsave constructor with the necessary parameters needed to construct a jobsave object
    function __construct($i,$si,$ji,$s,$d) {
        $this->id = $i;
        $this->sId = $si;
        $this->jId = $ji;
        $this->status = $s;
        $this->date = $d;
}

///////////////////////////////
//////////GET METHODS/////////
/////////////////////////////

public function getId(){
    return $this->id;
}

public function getSId(){
    return $this->sId;
}

public function getJId(){
    return $this->jId;
}

public function getStatus(){
    return $this->status;
}

public function getDate(){
    return $this->date;
}

///////////////////////////////
//////////SET METHODS/////////
/////////////////////////////

public function setId($i){
    $this->id = $i;
}

public function setSId($si){
    $this->sId = $si;
}

public function setJId($ji){
    $this->jId = $ji;
}

public function setStatus($s){
    $this->status = $s;
}

public function setDate($d){
    $this->date = $d;
}

}
?>

