<?php

require_once 'DB.php';
require_once 'employerTable.php';

//define the rootpath address
define('ROOTPATH', dirname(__FILE__));


function uploadPicture($pic2) {
    $result = NULL;

    if ($pic2["error"] > 0) {
        echo "Error: " . $pic2["error"] . "<br />";
    } else {
        $folder = ROOTPATH . "/imageRes";
        if (!is_dir($folder)) {
            echo 'making folder';
            mkdir($folder);
        }
        $file = $folder . "/" . $pic2["name"];
        if (file_exists($file)) {
            $result = $pic2["name"];
        } else {
            if (move_uploaded_file($pic2["tmp_name"], $file)) {
                $result = $pic2["name"];
            }
        }
    }
    return $result;
}

//variables used to store the POST values from the employer
$fName = $_POST['fName'];
$lName = $_POST['surname'];
$company = $_POST['company'];
$email = $_POST['email'];
$bio = $_POST['bio'];
$password = $_POST['password'];
//location can be updated in "Edit Profile"
$location = "Update";
//default image used
$pic = "noImage.jpeg";




try {
    ini_set("display_errors", 1);

    //establish a connection
    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);
    
    //instantiate a new employer table, passing the connection details as a parameter
    $table = new employerTable($connection);

    //instantiate a new employer object
    $employer = new employer(-1, $fName, $lName,$company, $email, $location, $bio, $pic, $password );
    //addEmployer will add the newly created employer object into the database and return the id which will be stored.
    $id = $table->addEmployer($employer);
    //the employer object's id will be set.
    $employer->setId($id);
    
    //redirect to login page
    header("Location: login.php");
} catch (PDOException $e) {
    //if a problem occurs, close the connection
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>