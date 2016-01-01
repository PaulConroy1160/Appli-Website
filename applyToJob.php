<?php

session_start();

if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'application.php';
require_once 'applicationTable.php';
require_once 'jobsTable.php';
require_once 'job.php';




$jId = $_POST['jId'];
$empId = $_POST['empId'];
$sId = $_SESSION['id'];
$status = 1;





try {
    ini_set("display_errors", 1);



    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    $table = new applicationTable($connection);

    $application = new application(-1, $sId,$empId, $jId, $status);
    $id = $table->addApplicant($application);
    $application->setId($id);
    
    header("Location: sControlPanel.php");
} catch (PDOException $e) {
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>