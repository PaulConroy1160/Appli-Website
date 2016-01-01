<?php

//require the jobSave object.
require_once 'jobSave.php';

class jobSaveTable {

    const TABLE_NAME = "jobsave";
    const COLUMN_ID = "id";
    const COLUMN_SID = "sId";
    const COLUMN_JID = "jId";
    const COLUMN_STATUS = "status";
    const COLUMN_DATE = "date";
    

    private $mConnection;

    //jobSaveTable constructor with the necessary connection parameter necessary to construct
    //a jobSaveTable object.
    public function __construct($Connection) {
        $this->mConnection = $Connection;
    }

    //jobSaveTable destruct method, used to close the connection to the jobSaveTable.
    public function __destruct() {
        $this->mConnection = null;
    }

    public function showAllUnseen() {
        // set the SQL SHOWALLUNSEEN statement that will display all job saves with unseen statuses.
        $sql = "SELECT * FROM " . jobSaveTable::TABLE_NAME . " WHERE " . jobSaveTable::COLUMN_STATUS . " = 1";

        //prepare the SQL statement.
        $stmt = $this->mConnection->prepare($sql);
        //execute the SQL statement.
        $status = $stmt->execute();

        //if the SQL statement does not execute - throw an exception and display an error message.
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display jobsaves: " . $errorInfo[2]);
        }

        //declaring a jobSaves array.
        $jobSaves = array();
        
        //fetch the values from each column in the jobSave table.
        //iterate through the table - storing each value.
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row[jobSaveTable::COLUMN_ID];
            $seekerId = $row[jobSaveTable::COLUMN_SID];
            $jobId = $row[jobSaveTable::COLUMN_JID];
            $status = $row[jobSaveTable::COLUMN_STATUS];
            $date = $row[jobSaveTable::COLUMN_DATE];

            //instantiate a new jobSave object, constructing it using the 
            //values as the constructor's parameters.
            $jobSave = new jobSave($id, $seekerId, $jobId, $status, $date);
            //storing the jobSave object into the jobSaves array.
            $jobSaves[$id] = $jobSave;
            
            //iterate through the table again.
            $row = $stmt->fetch();
        }
        //return the array of jobSaves.
        return $jobSaves;
    }
    
     public function addJobSave($jobSave) {
        // set the SQL addJobSave statement with a named placeholder for the jobSave's details.
        $sql = "INSERT INTO " . jobSaveTable::TABLE_NAME . "(" .
                jobSaveTable::COLUMN_SID . " , " .
                jobSaveTable::COLUMN_JID . " , " .
                jobSaveTable::COLUMN_STATUS . " , " .
                jobSaveTable::COLUMN_DATE . " ) " .
                "VALUES (:sId, :jId, :status, :date)";

        //declaring an array to hold the jobSave's value
        $params = array(
            'sId' => $jobSave->getSId(),
            'jId' => $jobSave->getJId(),
            'status' => $jobSave->getStatus(),
            'date' => $jobSave->getDate()
        );

        //preapre the SQL statement.
        $stmt = $this->mConnection->prepare($sql);
        //execute the SQL statement - passing the array of jobSave values.
        $status = $stmt->execute($params);

        //if the SQL statement does not execute - throw an exception and display an error message.
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not add job save: " . $errorInfo[2]);
        }

        //set the id of the jobSave.
        $id = $this->mConnection->lastInsertId(jobSaveTable::TABLE_NAME);
        
        //return the id.
        return $id;
    }
    
    
    
    public function findBySId($id) {
        // set the SQL SELECT statement with a named placeholder for the JobSave's sId to match with the passed id.
        $sql = "SELECT * FROM " . jobSaveTable::TABLE_NAME .
                " WHERE " . jobSaveTable::COLUMN_SID . " = :id";

        //declaring an array to hold the passed id value.
        $params = array('id' => $id);

        //preapre the SQL statement.
        $stmt = $this->mConnection->prepare($sql);
        //execute the SQL statement - passing the array containing the id value.
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve jobsave: " . $errorInfo[2]);
        }

        // if exactly one row was returned by the query then retrieve the JobSave's details
        // and construct a new jobSave object using the values of the jobSave as the parameters.
        $jobSave = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $id = $row[jobSaveTable::COLUMN_ID];
            $seekerId = $row[jobSaveTable::COLUMN_SID];
            $jobId = $row[jobSaveTable::COLUMN_SID];
            $status = $row[jobSaveTable::COLUMN_STATUS];
            $date = $row[jobSaveTable::COLUMN_DATE];

            $jobSave = new jobSave($id, $seekerId, $jobId, $status, $date);
        }

        // return the JobSave object if a JobSave with the specified id was found otherwise return null
        return $jobSave;
    }
    
    public function deleteSaveApplication($jobSaveId) {
        //set the SQL DELETE statement with a named placeholder for the jobSave id and match with passed id.
        $sql = "DELETE FROM " . jobSaveTable::TABLE_NAME .
                " WHERE " . jobSaveTable::COLUMN_ID . " = :id";

        //declaring an array and set the value for the id named placeholder in the SQL DELETE statement.
        $params = array('id' => $jobSaveId);

        // prepare the statement for execution and execute it
        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not delete job save: " . $errorInfo[2]);
        }

        // return the number of rows deleted by the SQL DELETE statement
        return $stmt->rowCount();
    }
}
    ?>