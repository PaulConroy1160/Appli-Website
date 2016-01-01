<?php

//require the job object.
require_once 'job.php';

class jobsTable {

    const TABLE_NAME = "jobs";
    const COLUMN_ID = "id";
    const COLUMN_TITLE = "title";
    const COLUMN_COMPANY = "company";
    const COLUMN_RPACKAGE = "rPackage";
    const COLUMN_SUMMARY = "summary";
    const COLUMN_EXPERIENCEREQ = "experienceReq";
    const COLUMN_RESPONSIBILITIES = "responsibilities";
    const COLUMN_LOCATION = "location";
    const COLUMN_CONTRACTTYPE = "contractType";
    const COLUMN_EMPID = "empID";
    const COLUMN_DATE = "date";
    

    private $mConnection;

    //jobsTable constructor with the necessary connection parameter necessary to construct
    //a jobsTable object.
    public function __construct($Connection) {
        $this->mConnection = $Connection;
    }

    //jobsTable destruct method, used to close the connection to the jobsTable.
    public function __destruct() {
        $this->mConnection = null;
    }

    public function showAll() {
        // set the SQL SHOWALL statement that will select all jobs.
        $sql = "SELECT * FROM " . jobsTable::TABLE_NAME;

        //prepare the SQL statement
        $stmt = $this->mConnection->prepare($sql);
        //execute the SQL statement.
        $status = $stmt->execute();

        //if the SQL statement does not execute - throw an exception and display an error message.
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display jobs: " . $errorInfo[2]);
        }

        //declaring a jobs array.
        $jobs = array();
        
        //fetch the values from each column in the jobSave table.
        //iterate through the table - storing each value.
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row[jobsTable::COLUMN_ID];
            $title = $row[jobsTable::COLUMN_TITLE];
            $company = $row[jobsTable::COLUMN_COMPANY];
            $rPackage = $row[jobsTable::COLUMN_RPACKAGE];
            $summary = $row[jobsTable::COLUMN_SUMMARY];
            $experienceReq = $row[jobsTable::COLUMN_EXPERIENCEREQ];
            $responsibilities = $row[jobsTable::COLUMN_RESPONSIBILITIES];
            $location = $row[jobsTable::COLUMN_LOCATION];
            $contractType = $row[jobsTable::COLUMN_CONTRACTTYPE];
            $empId = $row[jobsTable::COLUMN_EMPID];
            $date = $row[jobsTable::COLUMN_DATE];

            //instantiate a new job object, constructing it using the 
            //values as the constructor's parameters.
            $job = new Job($id, $title, $company, $rPackage, $summary, $experienceReq, $responsibilities, $location, $contractType, $empId ,$date);
            //storing the job object into the jobs array.
            $jobs[$id] = $job;

            //iterate through the table again.
            $row = $stmt->fetch();
        }

        //return the array of jobs.
        return $jobs;
    }

    public function addJob($job) {
        // set the SQL addJob statement with a named placeholder for the job's details.
        $sql = "INSERT INTO " . jobsTable::TABLE_NAME . "(" .
                jobsTable::COLUMN_TITLE . " , " .
                jobsTable::COLUMN_COMPANY . " , " .
                jobsTable::COLUMN_RPACKAGE . " , " .
                jobsTable::COLUMN_SUMMARY . " , " .
                jobsTable::COLUMN_EXPERIENCEREQ . " , " .
                jobsTable::COLUMN_RESPONSIBILITIES . " , " .
                jobsTable::COLUMN_LOCATION . " , " .
                jobsTable::COLUMN_CONTRACTTYPE . " , " .
                jobsTable::COLUMN_EMPID . " , " .
                jobsTable::COLUMN_DATE . " ) " .
                "VALUES (:title, :company, :rPackage, :summary, :experienceReq, :responsibilities, :location, :contractType, :empid, :date)";

        //declaring an array to hold the job's value
        $params = array(
            'title' => $job->getTitle(),
            'company' => $job->getCompany(),
            'rPackage' => $job->getRPackage(),
            'summary' => $job->getSummary(),
            'experienceReq' => $job->getExReq(),
            'responsibilities' => $job->getResponsibilities(),
            'location' => $job->getLocation(),
            'contractType' => $job->getContractType(),
            'empid' => $job->getEmpId(),
            'date' => $job->getDate()
        );

        //preapre the SQL statement.
        $stmt = $this->mConnection->prepare($sql);
        //execute the SQL statement - passing the array of job's values.
        $status = $stmt->execute($params);

        //if the SQL statement does not execute - throw an exception and display an error message.
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not add job: " . $errorInfo[2]);
        }

        //set the id of the job.
        $id = $this->mConnection->lastInsertId(jobsTable::TABLE_NAME);

        //return the id.
        return $id;
    }

    public function findById($id) {
        // set the SQL SELECT statement with a named placeholder for the Job's id to match with the passed id.
        $sql = "SELECT * FROM " . jobsTable::TABLE_NAME .
                " WHERE " . jobsTable::COLUMN_ID . " = :id";

        //declaring an array to hold the passed id value.
        $params = array('id' => $id);

        //preapre the SQL statement.
        $stmt = $this->mConnection->prepare($sql);
        //execute the SQL statement - passing the array containing the id value.
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve job: " . $errorInfo[2]);
        }

        // if exactly one row was returned by the query then retrieve the job's details
        // and construct a new job object using the values as the parameters.
        $job = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $id = $row[jobsTable::COLUMN_ID];
            $title = $row[jobsTable::COLUMN_TITLE];
            $company = $row[jobsTable::COLUMN_COMPANY];
            $rPackage = $row[jobsTable::COLUMN_RPACKAGE];
            $summary = $row[jobsTable::COLUMN_SUMMARY];
            $experienceReq = $row[jobsTable::COLUMN_EXPERIENCEREQ];
            $responsibilities = $row[jobsTable::COLUMN_RESPONSIBILITIES];
            $location = $row[jobsTable::COLUMN_LOCATION];
            $contractType = $row[jobsTable::COLUMN_CONTRACTTYPE];
            $empId = $row[jobsTable::COLUMN_EMPID];
            $date = $row[jobsTable::COLUMN_DATE];

            $job = new Job($id, $title, $company, $rPackage, $summary, $experienceReq, $responsibilities, $location, $contractType, $empId ,$date);
        }

        // return the Job object if a Job with the specified id was found otherwise return null
        return $job;
    }
}
?>
