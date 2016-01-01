<?php

session_start();

//if the session is not the specified seeker session created at login - the user
//will be redirected to the login page.
if (!$_SESSION['seeker']) {
    header("location: login.php");
}

//require the necessary classes
require_once 'DB.php';
require_once 'jobSaveTable.php';

//store the saveId value passed through the GET method.
$saveId = $_GET['saveId'];

try {
    ini_set("display_errors", 1);

    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    //instantiate a new jobSaveTable - passing in the connection as the parameters.
    $table = new jobSaveTable($connection);

    //execute the deleteSaveApplication method passing the stored save id as a parameter.
    $table->deleteSaveApplication($saveId);
    
    //redirect the seeker back to the viewSavedApplications page.
    header("Location: viewSavedApplications.php?saveNum=0");
} catch (PDOException $e) {
    //if a problem occurs - close the connection.
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>