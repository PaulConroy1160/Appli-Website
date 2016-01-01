<?php

mysql_connect("daneel", "N00090048", "N00090048");
mysql_select_db("n00090048");


require_once 'DB.php';
require_once 'seekerTable.php';

require_once 'jobSaveTable.php';

$sId = $_POST['sId'];
$sId = (int) $sId;
$jId = $_POST['jId'];
$jId = (int) $jId;



$seen = 1;


$status = $seen;
$saveDate = getdate();

//if data has been set

try {
    ini_set("display_errors", 1);
    ob_start();

    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    $seekerTable = new seekerTable($connection);
    $jobSaveTable = new jobSaveTable($connection);

    $jobSave = new jobSave(-1, $sId, $jId, $status, $saveDate);

    $id = $jobSaveTable->addJobSave($jobSave);
    $jobSave->setId($id);
} catch (PDOException $e) {
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>