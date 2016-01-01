<?php

//start session
session_start();

//if the session is not the specified employer session created at login - the user
//will be redirected to the login page
if (!$_SESSION['employer']) {
    header("location: login.php");
}

//require the following object and table classes
require_once 'DB.php';
require_once 'employerTable.php';
require_once 'jobsTable.php';
require_once 'job.php';



//variables used to store POST values sent from the postJob page
$title = $_POST['title'];
$company = $_POST['company'];
$rPackage = $_POST['rPackage'];
$summary = $_POST['summary'];
$experience = $_POST['experience'];
$responsibility = $_POST['responsibilities'];
$location = $_POST['location'];
$contract = $_POST['contract'];
//eId variable stores the employer's id stored in the session
$eId = $_SESSION['id'];
//current date will be stored in date variable
$date = date("j/ n/ Y");




try {
    ini_set("display_errors", 1);

    //establish a connection
    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    //instantiate a new employer table, passing the connection details as a parameter
    $table = new jobsTable($connection);

    //instantiate a new job object
    $job = new job(-1, $title, $company, $rPackage, $summary, $experience, $responsibility, $location, $contract, $eId, $date);
    //addJob will add the newly created job object into the database and return the id which will be stored.
    $id = $table->addJob($job);
    //the job object's id will be set.
    $job->setId($id);
    
    //redirect to the employer's control panel
    header("Location: eControlPanel.php");
} catch (PDOException $e) {
    //if a problem occurs, close the connection
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>