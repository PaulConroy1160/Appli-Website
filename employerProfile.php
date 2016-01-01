<?php
session_start();

require_once 'DB.php';
require_once 'employerTable.php';
require_once 'employer.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/resume.css">
    </head>
    <body>
        <?php
        try {
            ini_set("display_errors", 1);


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            //instantiates a new employer table passing the connection details to access the DB
            $table = new employerTable($connection);
            //stores the employer id passed through the GET method
            $id = $_GET["id"];
            //find and store the relevant employer object using the id. 
            $employer = $table->findById($id);
            


            //retrieve and store all information on the employer.
            $fName = $employer->getFName();
            $lName = $employer->getLName();
            $location = $employer->getLocation();
            $company = $employer->getCompany();
            $email = $employer->getEmail();
            $bio = $employer->getBio();
            $picture = $employer->getPhoto();
        } catch (PODException $e) {
            //if unsuccessful, close the connection.
            $connection = null;
            exit("Connection Failed: " . $e->getMessage());
        }
        ?>
        <div id="header">
            <header class="container_16">
                <div id="logo">
                    <div id="logo" class="grid_10">
                        <h1>appli.</h1>
                    </div>
                    <div id="nav" class="grid_6">

                    </div>
                </div>
        </div>
        <div id="mainDiv-default">
            <div id = "mainBody" class="container_16">
                <div id="mainHeader" class="grid_7">
                    <h1> <?php echo $fName; ?> <?php echo $lName; ?></h1>
                    <h3> Company: <?php echo $company; ?> </h3>

                </div>
                <div id="mainPhoto" class="grid_4">
                    <img src="imageRes/<?PHP echo $employer->getPhoto(); ?>" width="240px" height="240px">
                </div>
            </div>
        </div>
        <div id="lowerDiv">
            <div id="lowerBody" class="container_16">
                <div id="userBody" class="grid_10">
                    <div id="userBio">
                        <p><?php echo $bio; ?> </p>
                    </div>

                </div>
            </div>
            <div id="footer">
                <div id ="footerBody" class="container_16">

                    <div id="contactInfo" class="grid_16">
                        <h3>Contact Me</h3> 
                        <p>Email: <?php echo $email; ?> </p>
                    </div>
                </div>
            </div>
    </body>
</html>