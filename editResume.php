<?php
session_start();

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

    //gets the user id and searches the member table for matching id
    $id = $_SESSION["id"];
    $table = new seekerTable($connection);
    $seeker = $table->findById($id);
    
    $theme = $seeker->getTheme();
    
    if (isset($_POST['submit'])) {
        $fName = filter_var($_POST['fName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lName = filter_var($_POST['lName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dob = filter_var($_POST['dob'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = filter_var($_POST['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $education = filter_var($_POST['education'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $experience = filter_var($_POST['experience'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $bio = filter_var($_POST['bio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $theme = filter_var($_POST['theme'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $picture = $_FILES['picture'];
        
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
        <div id="page-container<?php echo $theme; ?>">
            <div id="header">
                <header class="container_16">
                    <div id="logo">
                        <div id="logo" class="grid_10">
                             <h1><a href="sControlPanel.php">appli.</a></h1>
                        </div>
                        <div id="nav" class="grid_6">
                            <ul>
                                <li><a href="sControlPanel.php">Control Panel</a></li>
                                <li><a href="resume.php?id=<?php echo $id; ?>" target="_blank">Résumé</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
            <div id="controlPanelMain">
                <div id = "mainBody" class="container_16">
                    <div id="formWrap">

                        <form class="form-horizontal" action="updateResume.php" enctype="multipart/form-data" method="post">

                            <fieldset>

                                <!-- Form -->
                                <legend><h1>Edit Résumé</h1></legend>
                                

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="fName">First Name</label>  
                                    <div class="col-md-6">
                                        <input id="" name="" class="form-control input-md" type="text" disabled="true" value="<?php echo $seeker->getFName() ?>">
                                        <input id="fName" name="fName"  type="hidden" value="<?php echo $seeker->getFName() ?>">
                                    </div>
                                </div>

                                <!-- Surname -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="lName">Surname</label>  
                                    <div class="col-md-6">
                                        <input id="lName" name=""  class="form-control input-md" type="text" disabled="true" value="<?php echo $seeker->getLName() ?>">
                                        <input id="lName" name="lName" type="hidden" value="<?php echo $seeker->getLName() ?>">    
                                    </div>
                                </div>

                                <!-- DOB -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="dob">Age</label>  
                                    <div class="col-md-6">
                                        <input id="dob" name="dob" placeholder="Your age." class="form-control input-md" type="text" value="<?php echo $seeker->getDOB() ?>">

                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email">Email</label>  
                                    <div class="col-md-6">
                                        <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text" value="<?php echo $seeker->getEmail() ?>">

                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="location">Location</label>  
                                    <div class="col-md-6">
                                        <input id="location" name="location" placeholder="Location" class="form-control input-md" type="text" value="<?php echo $seeker->getLocation() ?>">

                                    </div>
                                </div>

                                <!-- Education -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="education">Education</label>  
                                    <div class="col-md-6">
                                        <input id="education" name="education" placeholder="Seperate each with a comma" class="form-control input-md" type="text" value="<?php echo $seeker->getEducation() ?>">

                                    </div>
                                </div>

                                <!-- Experience -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="experience">Experience</label>
                                    <div class="col-md-6">                     
                                        <input id="experience" class="form-control input-md" name="experience" placeholder="Seperate each with a comma" value="<?php echo $seeker->getExperience() ?>"></input>
                                    </div>
                                </div>

                                <!-- Bio -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="bio">Bio</label>
                                    <div class="col-md-6">                     
                                        <textarea class="form-control" id="bio" name="bio"><?php echo $seeker->getBio(); ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- Password NOT VISIBLE -->
                                <div class="form-group">
                                    <div class="col-md-6">                     
                                        <input type="hidden" class="form-control" id="password" name="password" value="<?php echo $seeker->getPassword() ?>"></input>
                                    </div>
                                </div>
                                
                                <!-- Theme -->
                                <div class="form-group">
                                    <label class ="col-md-4 control-label" for="theme">Theme</label>
                                    <div class="col-md-7">
                                        <input id="theme" name="theme" class="radio-inline" type="radio" value="-default" checked>appli (default)</input>
                                    <input id="theme" name="theme" class="radio-inline" type="radio" value="-pink">Rogue Pink</input>
                                    <input id="theme" name="theme" class="radio-inline" type="radio" value="-blue">Cobalt Blue</input>
                                    <input id="theme" name="theme" class="radio-inline" type="radio" value="-navy">Dark Navy</input>
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


