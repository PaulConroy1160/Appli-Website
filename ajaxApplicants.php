<?php
session_start();

if (!$_SESSION['employer']) {
    header("location: login.php");
}

//DB information required to access the database
$dbhost = "daneel";
$dbuser = "N00090048";
$dbpass = "N00090048";
$dbname = "n00090048";
//notifCount variable used to count the number of notifications
$notifCount = 0;

//Connect to MySQL Server
mysql_connect($dbhost, $dbuser, $dbpass);
//Select Database
mysql_select_db($dbname) or die(mysql_error());

//id variable used to store the id value stored in the employer session
$id = $_SESSION['id'];

//query string that will be used to query the database and find each application that matches the employer's id
//and status is equal to 1
$query = "SELECT * FROM applications WHERE empId = ".$id." AND status = '1'";

//Execute query
$qry_result = mysql_query($query) or die(mysql_error());


// Insert a new row in the table for each person returned
while($row = mysql_fetch_array($qry_result)){
	if("$row[status]" == true){
		$notifCount++;
	}
}

//returnedString is created, this will hold the notifCount
$returnedString = "";
if($notifCount > 0){
    $returnedString = "" .$notifCount;
} else {
    $returnedString = "";    
};

//echo the returnedString
echo $returnedString;

?>