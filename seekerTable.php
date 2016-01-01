<?php

require_once 'seeker.php';

class seekerTable {

    const TABLE_NAME = "seekerAccounts";
    const COLUMN_ID = "id";
    const COLUMN_FNAME = "fName";
    const COLUMN_LNAME = "lName";
    const COLUMN_DOB = "dob";
    const COLUMN_EMAIL = "email";
    const COLUMN_PASSWORD = "password";
    const COLUMN_LOCATION = "location";
    const COLUMN_EXPERIENCE = "experience";
    const COLUMN_EDUCATION = "education";
    const COLUMN_BIO = "bio";
    const COLUMN_THEME = "theme";
    const COLUMN_PICTURE = "picture";
    

    private $mConnection;

    public function __construct($Connection) {
        $this->mConnection = $Connection;
    }

    public function __destruct() {
        $this->mConnection = null;
    }

    public function showAll() {
        // construct the SQL SHOWALL statement that will display all seekers
        $sql = "SELECT * FROM " . seekerTable::TABLE_NAME;

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not display seekers: " . $errorInfo[2]);
        }

        $seekers = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row[seekerTable::COLUMN_ID];
            $fName = $row[seekerTable::COLUMN_FNAME];
            $lName = $row[seekerTable::COLUMN_LNAME];
            $dob = $row[seekerTable::COLUMN_DOB];
            $email = $row[seekerTable::COLUMN_EMAIL];
            $password = $row[seekerTable::COLUMN_PASSWORD];
            $location = $row[seekerTable::COLUMN_LOCATION];
            $experience = $row[seekerTable::COLUMN_EXPERIENCE];
            $education = $row[seekerTable::COLUMN_EDUCATION];
            $bio = $row[seekerTable::COLUMN_BIO];
            $theme = $row[seekerTable::COLUMN_THEME];
            $picture = $row[seekerTable::COLUMN_PICTURE];

            $seeker = new Seeker($id, $fName, $lName, $dob, $email, $password, $location, $experience, $education, $bio, $theme ,$picture);
            $seekers[$id] = $seeker;

            $row = $stmt->fetch();
        }

        return $seekers;
    }

    public function addSeeker($seeker) {
        // construct the SQL ADDSEEKER statement with a named placeholder for the seekers details
        $sql = "INSERT INTO " . seekerTable::TABLE_NAME . "(" .
                seekerTable::COLUMN_FNAME . " , " .
                seekerTable::COLUMN_LNAME . " , " .
                seekerTable::COLUMN_DOB . " , " .
                seekerTable::COLUMN_EMAIL . " , " .
                seekerTable::COLUMN_PASSWORD . " , " .
                seekerTable::COLUMN_LOCATION . " , " .
                seekerTable::COLUMN_EXPERIENCE . " , " .
                seekerTable::COLUMN_EDUCATION . " , " .
                seekerTable::COLUMN_BIO . " , " .
                seekerTable::COLUMN_THEME . " , " .
                seekerTable::COLUMN_PICTURE . " ) " .
                "VALUES (:fName, :lName, :dob, :email, :password, :location, :experience, :education, :bio, :theme, :picture)";

        $params = array(
            'fName' => $seeker->getFName(),
            'lName' => $seeker->getLName(),
            'dob' => $seeker->getDob(),
            'email' => $seeker->getEmail(),
            'password' => $seeker->getPassword(),
            'location' => $seeker->getLocation(),
            'experience' => $seeker->getExperience(),
            'education' => $seeker->getEducation(),
            'bio' => $seeker->getBio(),
            'theme' => $seeker->getTheme(),
            'picture' => $seeker->getPicture()
        );

        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not add seeker: " . $errorInfo[2]);
        }

        $id = $this->mConnection->lastInsertId(seekerTable::TABLE_NAME);

        return $id;
    }

    public function deleteSeeker($memberId) {
        // construct the SQL DELETE statement with a named placeholder for the seeker id
        $sql = "DELETE FROM " . SeekerTable::TABLE_NAME .
                " WHERE " . seekerTable::COLUMN_ID . " = :id";

        // the value for the id named placeholder in the SQL DELETE statement
        $params = array('id' => $memberId);

        // prepare the statement for execution and execute it
        $stmt = $this->mConnection->prepare($sql);
        $status = $stmt->execute($params);

        // if an error occurred while executing the query then throw an exception
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not delete seeker: " . $errorInfo[2]);
        }

        // return the number of rows deleted by the SQL DELETE statement
        return $stmt->rowCount();
    }

    public function findById($id) {
        // construct the SQL SELECT statement with a named placeholder for the seeker id
        $sql = "SELECT * FROM " . seekerTable::TABLE_NAME .
                " WHERE " . seekerTable::COLUMN_ID . " = :id";

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
        $seeker = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $id = $row[seekerTable::COLUMN_ID];
            $fName = $row[seekerTable::COLUMN_FNAME];
            $lName = $row[seekerTable::COLUMN_LNAME];
            $dob = $row[seekerTable::COLUMN_DOB];
            $email = $row[seekerTable::COLUMN_EMAIL];
            $password = $row[seekerTable::COLUMN_PASSWORD];
            $location = $row[seekerTable::COLUMN_LOCATION];
            $experience = $row[seekerTable::COLUMN_EXPERIENCE];
            $education = $row[seekerTable::COLUMN_EDUCATION];
            $bio = $row[seekerTable::COLUMN_BIO];
            $theme = $row[seekerTable::COLUMN_THEME];
            $picture = $row[seekerTable::COLUMN_PICTURE];

            $seeker = new Seeker($id, $fName, $lName, $dob, $email, $password, $location, $experience, $education, $bio, $theme, $picture);
        }

        // return the Seeker object if a Seeker with the specified id was found otherwise return null
        return $seeker;
    }

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
                seekerTable::COLUMN_BIO . " = :bio, " .
                seekerTable::COLUMN_THEME . " = :theme, " .
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
            'bio' => $seeker->getBio(),
            'theme' => $seeker->getTheme(),
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

}

?>
