<?php

//require the following object and table classes, including the DB to create a connection
require_once 'DB.php';
require_once 'seekerTable.php';

//define the rootpath
define('ROOTPATH', dirname(__FILE__));

//uploadPicture function is used to move the uploaded picture file to the correct folder
//in the rootpath
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
    //returns name of the picture file
    return $result;
}



//variables used to store POST values sent from the signUpSeeker page
$fName = $_POST['fName'];
$lName = $_POST['surname'];
$dob = "Update";
$email = $_POST['email'];
$bio = $_POST['bio'];
$password = $_POST['password'];
$location = "Update";
$experience = "Update";
$education = "Update";
//theme variable stores the value "-default" - used to display default css div theme
$theme = "-default";
//pic variable uses the uploadPicture method to pass the picture file to the correct directory
$pic = uploadPicture($picture);
    //checks if image has been added, if not, default image is chosen
    if ($pic === NULL) {
        $pic = "noImage.jpeg";
    }




try {
    ini_set("display_errors", 1);
    
    //establish a connection
    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    //instantiate a new seeker table, passing the connection details as a parameter
    $table = new seekerTable($connection);

    //instantiate a new seeker object
    $seeker = new seeker(-1, $fName, $lName,$dob, $email, $password, $location, $experience, $education, $bio, $theme, $pic );
   
    //addSeeker will add the newly created seeker object into the database and return the id which will be stored.
    $id = $table->addSeeker($seeker);
    //the seeker object's id will be set.
    $seeker->setId($id);
    
    //redirect to the login page
    header("Location: login.php");
} catch (PDOException $e) {
    //if a problem occurs, close the connection.
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>