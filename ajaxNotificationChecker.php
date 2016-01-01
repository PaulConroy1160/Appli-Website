<?php
/*
class ajaxNotificationChecker{
    
    const TABLE_NAME = "applications";
    const COLUMN_ID = "id";
    const COLUMN_SEEKERID = "seekerId";
    const COLUMN_EMPID = "empId";
    const COLUMN_JOBID = "jobId";
    const COLUMN_STATUS = "status";
    
    
    

    private $mConnection;

    public function __construct($Connection) {
        $this->mConnection = $Connection;
    }

    public function __destruct() {
        $this->mConnection = null;
    }


    public function __autoload() {
        
        $notifCount = 0;
        // construct the SQL SHOWALL statement that will display all seekers
        $sql = "SELECT * FROM " . ajaxNotificationChecker::TABLE_NAME . "WHERE " . ajaxNotificationChecker::COLUMN_STATUS . " = '1";

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute();
        
        while($row = mysql_fetch_array($qry_result)){
	if("$row[status]" == true){
		$notifCount++;
            }
        }

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display notifications: " . $errorInfo[2]);
        }

        $returnedString = "";
        if($notifCount > 0){ $returnedString = "Notifications " .$notifCount;} else {$returnedString = "";};
       
        
         return $returnedString;
    }
}

 */



$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "appli";
$notifCount = 0;

	//Connect to MySQL Server
mysql_connect($dbhost, $dbuser, $dbpass);
	//Select Database
mysql_select_db($dbname) or die(mysql_error());



$query = "SELECT * FROM applications WHERE status = '1'";

	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

	//Build Result String
//$display_string = "<h1>";

// Insert a new row in the table for each person returned
while($row = mysql_fetch_array($qry_result)){
	if("$row[status]" == true){
		$notifCount++;
	}
}

//$display_string .= "</h1>";
$returnedString = "";
if($notifCount > 0){ 
    $returnedString = "" .$notifCount;
    
} else {
    $returnedString = "";
    
};

echo $returnedString;

?>