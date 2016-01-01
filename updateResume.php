<?php
session_start();

//if session is not the username declared at login check page, return the user to login page
if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';

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
    $table = new seekerTable($connection);
    $seeker = $table->findById($id);
    
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
        $picture = $seeker->getPicture();
    }
    


    //sets and sanitizes the data from the form
    
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
            'fName' => $_POST["fName"],
            'lName' => filter_var($_POST['lName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'dob' => filter_var($_POST['dob'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'password' => filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'location' => filter_var($_POST['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'experience' => filter_var($_POST['experience'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'education' => filter_var($_POST['education'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'bio' => filter_var($_POST['bio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'theme' =>  filter_var($_POST['theme'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'picture' => $picture,
            'id' => $_SESSION['id']
        );
        
   
         $stmt = $connection->prepare($sql);
         $status = $stmt->execute($params);

            if ($status != true) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Could not update member: " . $errorInfo[2]);
            }


        
        header("location: sControlPanel.php");
    
} catch (PDOException $e) {
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>