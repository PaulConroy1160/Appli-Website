<?php

require_once 'employer.php';

class employerTable{
    const TABLE_NAME = "employerAccount";
    const COLUMN_ID = "id";
    const COLUMN_FNAME = "fName";
    const COLUMN_LNAME = "lName";
    const COLUMN_COMPANY = "company";
    const COLUMN_EMAIL = "email";
    const COLUMN_LOCATION = "location";
    const COLUMN_BIO = "bio";
    const COLUMN_PHOTO = "photo";
    const COLUMN_PASSWORD = "password";
    
    private $mConnection;
    
    public function __construct($Connection) {
        $this->mConnection = $Connection;
    }
    
    public function __destruct() {
        $this->mConnection = null;
    }
    
    public function showAll(){
        // construct the SQL SHOWALL statement that will display all employers
        $sql = "SELECT * FROM " . employerTable::TABLE_NAME;
        
        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display employers: " . $errorInfo[2]);
        }
        
        $employers = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row[employerTable::COLUMN_ID];
            $fName = $row[employerTable::COLUMN_FNAME];
            $lName = $row[employerTable::COLUMN_LNAME];
            $company = $row[employerTable::COLUMN_COMPANY];
            $email = $row[employerTable::COLUMN_EMAIL];
            $location = $row[employerTable::COLUMN_LOCATION];
            $bio = $row[employerTable::COLUMN_BIO];
            $photo = $row[employerTable::COLUMN_PHOTO];
            $password = $row[employerTable::COLUMN_PASSWORD];

            $employer = new Employer($id, $fName, $lName, $company, $email, $location, $bio, $photo, $password);
            $employers[$id] = $employer;

            $row = $stmt->fetch();
        }
        
        return $employers;
    }
    
    public function findById($id) {
        // construct the SQL SELECT statement with a named placeholder for the seeker id
        $sql = "SELECT * FROM " . employerTable::TABLE_NAME .
                " WHERE " . employerTable::COLUMN_ID . " = :id";

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
        $employer = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $id = $row[employerTable::COLUMN_ID];
            $fName = $row[employerTable::COLUMN_FNAME];
            $lName = $row[employerTable::COLUMN_LNAME];
            $company = $row[employerTable::COLUMN_COMPANY];
            $email = $row[employerTable::COLUMN_EMAIL];
            $location = $row[employerTable::COLUMN_LOCATION];
            $bio = $row[employerTable::COLUMN_BIO];
            $photo = $row[employerTable::COLUMN_PHOTO];
            $password = $row[employerTable::COLUMN_PASSWORD];

            $employer = new Employer($id, $fName, $lName, $company, $email, $location, $bio, $photo, $password);
        }

        // return the Seeker object if a Seeker with the specified id was found otherwise return null
        return $employer;
    }
    
    public function addEmployer($employer) {
        // construct the SQL ADDEMPLOYER statement with a named placeholder for the employer's details
        $sql = "INSERT INTO " . employerTable::TABLE_NAME . "(" .
                employerTable::COLUMN_FNAME . " , " .
                employerTable::COLUMN_LNAME . " , " .
                employerTable::COLUMN_COMPANY . " , ".
                employerTable::COLUMN_EMAIL . " , " .
                employerTable::COLUMN_LOCATION . " , " .
                employerTable::COLUMN_BIO . " , " .
                employerTable::COLUMN_PHOTO . " , " .
                employerTable::COLUMN_PASSWORD . " ) " .
                "VALUES (:fName, :lName, :company, :email, :location, :bio, :picture, :password)";

        $params = array(
            'fName' => $employer->getFName(),
            'lName' => $employer->getLName(),
            'company' => $employer->getCompany(),
            'email' => $employer->getEmail(),
            'location' => $employer->getLocation(),
            'bio' => $employer->getBio(),
            'picture' => $employer->getPhoto(),
            'password' => $employer->getPassword()
        );

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not add employer: " . $errorInfo[2]);
        }

        $id = $this->mConnection->lastInsertId(employerTable::TABLE_NAME);

        return $id;
    }
    
}


?>
