<?php
session_start();

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

    //gets the user id and searches the member table for matching id
    $id = $_SESSION["id"];
    $table = new employerTable($connection);
    $employer = $table->findById($id);
    
    if (isset($_POST['submit'])) {
        $company = filter_var($_POST['company'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fName = filter_var($_POST['fName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lName = filter_var($_POST['lName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = filter_var($_POST['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $bio = filter_var($_POST['bio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $picture = $_FILES['picture'];
        if ($picture === null) {
            $picture = $employer->getPicture();
        } else {
            $picture = uploadPicture($picture);
        }
        
    }
} catch (PDOException $e) {
    $connection = null;
    exit("Connection failed: " . $e->getMessage());
}
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <link rel="stylesheet" href="css/bootstrap.css">
    </head>
    <body>
        <div id="page-container-default">
            <div id="header">
                <header class="container_16">
                    <div id="logo">
                        <div id="logo" class="grid_10">
                             <h1><a href="eControlPanel.php">appli.</a></h1>
                        </div>
                        <div id="nav" class="grid_6">
                            <ul>
                                <li><a href="eControlPanel.php">Control Panel</a></li>
                                <li><a href="employerProfile.php?id=<?php echo $id; ?>" target="_blank">Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
            <div id="controlPanelMain">
                <div id = "mainBody" class="container_16">
                    <div id="formWrap">

                        <form class="form-horizontal" action="updateProfile.php" enctype="multipart/form-data" method="post">

                            <fieldset>

                                <!-- Form -->
                                <legend><h1>Edit Profile</h1></legend>
                                
                                <!-- Company -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="company">Company</label>  
                                    <div class="col-md-6">
                                        <input id="" name="" class="form-control input-md" type="text" disabled="true" value="<?php echo $employer->getCompany() ?>">
                                        <input id="company" name="company"  type="hidden" value="<?php echo $employer->getCompany() ?>">
                                    </div>
                                </div>
                                <!-- Name -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fName">First Name</label>  
                                    <div class="col-md-6">
                                        <input id="" name="" class="form-control input-md" type="text" disabled="true" value="<?php echo $employer->getFName() ?>">
                                        <input id="fName" name="fName"  type="hidden" value="<?php echo $employer->getFName() ?>">
                                    </div>
                                </div>

                                <!-- Surname -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="lName">Surname</label>  
                                    <div class="col-md-6">
                                        <input id="lName" name=""  class="form-control input-md" type="text" disabled="true" value="<?php echo $employer->getLName() ?>">
                                        <input id="lName" name="lName" type="hidden" value="<?php echo $employer->getLName() ?>">    
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email">Email</label>  
                                    <div class="col-md-6">
                                        <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text" value="<?php echo $employer->getEmail() ?>">

                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="location">Location</label>  
                                    <div class="col-md-6">
                                        <input id="location" name="location" placeholder="Location" class="form-control input-md" type="text" value="<?php echo $employer->getLocation() ?>">

                                    </div>
                                </div>

                                <!-- Bio -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="bio">Bio</label>
                                    <div class="col-md-6">                     
                                        <textarea class="form-control" id="bio" name="bio"><?php echo $employer->getBio(); ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- Password NOT VISIBLE -->
                                <div class="form-group">
                                    <div class="col-md-6">                     
                                        <input type="hidden" class="form-control" id="password" name="password" value="<?php echo $employer->getPassword() ?>"></input>
                                    </div>
                                </div>

                                <!-- Upload --> 
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="picture">Upload Profile Photo</label>
                                    <div class="col-md-4">
                                        <input id="picture" name="picture" class="input-file" type="file">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="submit"></label>
                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-default">Submit</button>
                                    </div>
                                </div>
                                
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>



            <div id="footer">
                <div id ="footerBody" class="container_16">

                    <div id="contactInfo" class="grid_6">
                    </div>
                </div>
                </body>
                </html>


