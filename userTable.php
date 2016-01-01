<?php

require_once 'seeker.php';

class userTable{
    
    const TABLE_NAME = "seekerAccounts";
    const COLUMN_ID = "id";
    const COLUMN_FNAME = "fName";
    const COLUMN_LNAME = "lName";
    const COLUMN_EMAIL = "email";
    const COLUMN_PASSWORD = "password";
    
    private $mConnection;
    
    public function __construct($Connection) {
        $this->mConnection = $Connection;
    }
    
    public function __destruct(){
        $this->mConnection = null;
    }
    
    public function showAll(){
        
         // construct the SQL SHOWALL statement that will display all users
        $sql = "SELECT * FROM " . userTable::TABLE_NAME;

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display members: " . $errorInfo[2]);
        }

        $users = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row[userTable::COLUMN_ID];
            $fName = $row[userTable::COLUMN_FNAME];
            $lName = $row[userTable::COLUMN_LNAME];
            $email = $row[userTable::COLUMN_EMAIL];
            $password = $row[userTable::COLUMN_PASSWORD];

            $seeker = new Seeker($id, $fName, $lName, $email,$password);
            $seekers[$id] = $seeker;

            $row = $stmt->fetch();
        }

        return $seekers;
    }
}
?>
