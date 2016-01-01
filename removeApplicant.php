<?php

//start session.
session_start();

//if the session is not the specified employer session created at login - the user
//will be redirected to the login page.
if (!$_SESSION['employer']) {
    header("location: login.php");
}

//require the necessary classes
require_once 'DB.php';
require_once 'applicationTable.php';

//store the id value passed through the GET method.
$applicantId = $_GET['id'];


try {
    ini_set("display_errors", 1);


    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    //instantiate a new applicationTable - passing in the connection as the parameters.
    $table = new applicationTable($connection);

    //execute the deleteApplicant method passing the stored applicant id as a parameter.
    $table->deleteApplicant($applicantId);
    
    //redirect the user back to the viewApplicants page.
    header("Location: viewApplicants.php?saveNum=0");
} catch (PDOException $e) {
    //if a problem occurs, close the connection.
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>