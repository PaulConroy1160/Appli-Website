<?php

//Job class
class job{
    
    
    private $id;
    private $title;
    private $company;
    private $rPackage;
    private $summary;
    private $experienceReq;
    private $responsibilities;
    private $location;
    private $contractType;
    private $empId;
    private $date;
    
    //Job constructor with the necessary parameters needed to construct a job object
    function __construct($i,$t,$c,$rP,$s,$eR,$r,$l,$cT,$eID,$d) {
        $this->id = $i;
        $this->title = $t;
        $this->company = $c;
        $this->rPackage = $rP;
        $this->summary = $s;
        $this->experienceReq = $eR;
        $this->responsibilities = $r;
        $this->location = $l;
        $this->contractType = $cT;
        $this->empId = $eID;
        $this->date = $d;
}

///////////////////////////////
//////////GET METHODS/////////
/////////////////////////////

public function getId(){
    return $this->id;
}

public function getTitle(){
    return $this->title;
}

public function getCompany(){
    return $this->company;
}

public function getRPackage(){
    return $this->rPackage;
}

public function getSummary(){
    return $this->summary;
}

public function getExReq(){
    return $this->experienceReq;
}

public function getResponsibilities(){
    return $this->responsibilities;
}

public function getLocation(){
    return $this->location;
}

public function getContractType(){
    return $this->contractType;
}

public function getEmpID(){
    return $this->empId;
}

public function getDate(){
    return $this->date;
}

///////////////////////////////
//////////SET METHODS/////////
/////////////////////////////

public function setId($id){
    $this->id = $id;
}

public function setTitle($t){
    $this->title = $t;
}

public function setCompany($c){
    $this->company = $c;
}

public function setRPackage($rp){
    $this->rPackage = $rp;
}
    
public function setSummary($sum){
    $this->summary = $sum;
}

public function setExReq($exr){
    $this->experienceReq = $exr;
}

public function setResponsibilities($r){
    $this->responsibilities = $r;
}

public function setLocation($l){
    $this->location = $l;
}

public function setContractType($ct){
    $this->contractType = $ct;
}

public function setEmpId($eId){
    $this->empId = $eId;
}

public function setDate($d){
    $this->date = $d;
}
}
?>
