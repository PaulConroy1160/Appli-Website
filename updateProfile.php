<?php
session_start();

//if session is not the username declared at login check page, return the user to login page
if (!$_SESSION['employer']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'employerTable.php';
require_once 'employer.php';

define('ROOTPATH', dirname(__FILE__));

//sets the directory for the uploaded picture, if the directory does not exist, it will be created
function uploadPicture($pic2) {
    $result = NULL;

    if ($pic2["error"] > 0) {
        echo "Error: " . $pic2["error"] . "<br />";
    } else {
        $folder = ROOTPATH . "/imageRes";
        if (!is_dir($folder)) {
            echo 'making folder "' . $folder . '"';
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

try {
    ini_set("display_errors", 1);

    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);
    $id = $_SESSION["id"];
    $table = new employerTable($connection);
    $employer = $table->findById($id);
    
    $picture = $_FILES['picture'];
    /*
    if ($picture === null){
        $picture = "noImage.jpg";
    } else {
        $picture = uploadPicture($picture);
    }
     *
     */
    $picture = uploadPicture($picture);
    if($picture === null){
        $picture = $employer->getPhoto();
    }
    


    //sets and sanitizes the data from the form
    
    $sql = "UPDATE " . employerTable::TABLE_NAME . " SET " .
                employerTable::COLUMN_FNAME . " = :fName, " .
                employerTable::COLUMN_LNAME . " = :lName, " .
                employerTable::COLUMN_COMPANY . " = :company, " .
                employerTable::COLUMN_EMAIL . " = :email, " .
                employerTable::COLUMN_LOCATION . " = :location, " .
                employerTable::COLUMN_BIO . " = :bio, " .
                employerTable::COLUMN_PHOTO . " = :photo, " .
                employerTable::COLUMN_PASSWORD . " = :password " .
                "WHERE " . employerTable::COLUMN_ID . " = :id";

        // the values for the named placeholders in the SQL UPDATE statement
        $params = array(
            'fName' => $_POST["fName"],
            'lName' => filter_var($_POST['lName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'company' => filter_var($_POST['company'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'location' => filter_var($_POST['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'bio' => filter_var($_POST['bio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'photo' => $picture,
            'password' => filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'id' => $_SESSION['id']
        );
        
   
         $stmt = $connection->prepare($sql);
         $status = $stmt->execute($params);

            if ($status != true) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Could not update employer: " . $errorInfo[2]);
            }


        
        header("location: eControlPanel.php");
    
} catch (PDOException $e) {
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>