<?php

require_once 'application.php';

class applicationTable {

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

    public function showAll() {
        // construct the SQL SHOWALL statement that will display all applications
        $sql = "SELECT * FROM " . applicationTable::TABLE_NAME;

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display applications: " . $errorInfo[2]);
        }

        $jobs = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row[applicationTable::COLUMN_ID];
            $seekerId = $row[applicationTable::COLUMN_SEEKERID];
            $empId = $row[applicationTable::COLUMN_EMPID];
            $jobId = $row[applicationTable::COLUMN_JOBID];
            $status = $row[applicationTable::COLUMN_STATUS];

            $application = new Application($id, $seekerId, $empId, $jobId, $status);
            $applications[$id] = $application;

            $row = $stmt->fetch();
        }

        return $applications;
    }
    
    

    public function addApplicant($application) {
        // construct the SQL ADDSEEKER statement with a named placeholder for the seekers details
        $sql = "INSERT INTO " . applicationTable::TABLE_NAME . "(" .
                applicationTable::COLUMN_SEEKERID . " , " .
                applicationTable::COLUMN_EMPID . " , " .
                applicationTable::COLUMN_JOBID . " , " .
                applicationTable::COLUMN_STATUS . " ) " .
                "VALUES (:seekerId, :empId, :jobId, :status)";

        $params = array(
            'seekerId' => $application->getSeekerId(),
            'empId' => $application->getEmpId(),
            'jobId' => $application->getJobId(),
            'status' => $application->getStatus()
        );

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not add applicant: " . $errorInfo[2]);
        }

        $id = $this->mConnection->lastInsertId(applicationTable::TABLE_NAME);

        return $id;
    }

    public function deleteApplicant($applicantId) {
        // construct the SQL DELETE statement with a named placeholder for the applicant id
        $sql = "DELETE FROM " . applicationTable::TABLE_NAME .
                " WHERE " . applicationTable::COLUMN_ID . " = :id";

        // the value for the id named placeholder in the SQL DELETE statement
        $params = array('id' => $applicantId);

        // prepare the statement for execution and execute it
        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not delete applicant: " . $errorInfo[2]);
        }

        // return the number of rows deleted by the SQL DELETE statement
        return $stmt->rowCount();
    }
     
    public function findById($id) {
        // construct the SQL SELECT statement with a named placeholder for the application id
        $sql = "SELECT * FROM " . applicationTable::TABLE_NAME .
                " WHERE " . applicationTable::COLUMN_ID . " = :id";

        // the value for the id named placeholder in the SQL DELETE statement
        $params = array('id' => $id);

        // prepare the statement for execution and execute it
        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve book: " . $errorInfo[2]);
        }

        // if exactly one row was returned by the query then retrieve the seekers details
        // and store them in a Seeker object
        $application = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $id = $row[applicationTable::COLUMN_ID];
            $seekerId = $row[applicationTable::COLUMN_SEEKERID];
            $empId = $row[applicationTable::COLUMN_EMPID];
            $jobId = $row[applicationTable::COLUMN_JOBID];
            $status = $row[applicationTable::COLUMN_STATUS];

            $application = new Application($id, $seekerId, $empId, $jobId, $status);
        }

        // return the Application object if a Application with the specified id was found otherwise return null
        return $application;
    }
/*
    public function update($seeker) {
        // construct the SQL UPDATE statement with named placeholders for the member details
        $sql = "UPDATE " . seekerTable::TABLE_NAME . " SET " .
                seekerTable::COLUMN_FNAME . " = :fName, " .
                seekerTable::COLUMN_LNAME . " = :lName, " .
                seekerTable::COLUMN_DOB . " = :dob, " .
                seekerTable::COLUMN_EMAIL . " = :email, " .
                seekerTable::COLUMN_PASSWORD . " = :password, " .
                seekerTable::COLUMN_LOCATION . " = :location, " .
                seekerTable::COLUMN_EXPERIENCE . " = :experience, " .
                seekerTable::COLUMN_EDUCATION . " = :education, " .
                seekerTable::COLUMN_PICTURE . " = :picture " .
                "WHERE " . seekerTable::COLUMN_ID . " = :id";

        // the values for the named placeholders in the SQL UPDATE statement
        $params = array(
            'fName' => $seeker->getFName(),
            'lName' => $seeker->getLName(),
            'dob' => $seeker->getDob(),
            'email' => $seeker->getEmail(),
            'password' => $seeker->getPassword(),
            'location' => $seeker->getLocation(),
            'experience' => $seeker->getExperience(),
            'education' => $seeker->getEducation(),
            'picture' => $seeker->getPicture()
        );

        // prepare the statement for execution and execute it
        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not update seeker: " . $errorInfo[2]);
        }

        // return the number of rows updated by the SQL UPDATE statement
        return $stmt->rowCount();
    }

     
     */
}
?>
