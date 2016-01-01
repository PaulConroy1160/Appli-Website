<?php

//Application class
class application{
    //instance variables
    private $id;
    private $seekerId;
    private $empId;
    private $jobId;
    private $status;
    
    //application constructor with the necessary parameters needed to construct an application object
    function __construct($i,$sId,$eId,$jId,$s) {
        $this->id = $i;
        $this->seekerId = $sId;
        $this->empId = $eId;
        $this->jobId = $jId;
        $this->status = $s;
        
    }
    ///////////////////////////////
    //////////GET METHODS/////////
    /////////////////////////////
    
    public function getId(){
        return $this->id;
    }
    
    public function getSeekerId(){
        return $this->seekerId;
    }
    
    public function getEmpId(){
        return $this->empId;
    }
    
    public function getJobId(){
        return $this->jobId;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    ///////////////////////////////
    //////////SET METHODS/////////
    /////////////////////////////
    
    public function setId($sId){
        $this->id = $sId;
    }
    
    public function setSeekerId($sId){
        $this->seekerId = $sId;
    }
    
    public function setEmpId($eId){
        $this->empId = $eId;
    }
    
    public function setJobId($jId){
        $this->jobId = $jId;
    }
    
    public function setStatus($s){
        $this->status = $s;
    }
    
    
}
?>
