<?php 
session_start();

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
         <link rel="stylesheet" href="css/resume.css">
         <title>Résumé</title>
    </head>
    <body>
        <?php 
        try {
            ini_set("display_errors", 1);


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            //instantiates a new seeker table passing the connection details to access the DB
            $table = new seekerTable($connection);
            //stores the seeker id passed through the GET method
            $id = $_GET["id"];
            //find and store the relevant seeker object using the id. 
            $seeker = $table->findById($id);
            

            //retrieve and store all information on the seeker.
            $fName = $seeker->getFName();
            $lName = $seeker->getLName();
            $location = $seeker->getLocation();
            $age = $seeker->getDOB();
            $email = $seeker->getEmail();
            $education = $seeker->getEducation();
            $experience = $seeker->getExperience();
            $bio = $seeker->getBio();
            $theme = $seeker->getTheme();
            $picture = $seeker->getPicture();
            
        } catch (PODException $e) {
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
        </div
        <!-- custom themes will alter the mainDiv div id -->
        <div id="mainDiv<?php echo $theme; ?>">
            <div id = "mainBody" class="container_16">
                <div id="mainHeader" class="grid_7">
                    <h1> <?php echo $fName; ?> <?php echo $lName; ?></h1>
                    <h3> Age: <?php echo $age; ?></h3>

                </div>
                <div id="mainPhoto" class="grid_4">
                    <img src="imageRes/<?php echo $seeker->getPicture();?>" width="240px" height="240px">
                </div>
            </div>
        </div>
        <div id="lowerDiv">
            <div id="lowerBody" class="container_16">
                <div id="userBody" class="grid_10">
                    <div id="userBio">
                        <p><?php echo $bio; ?> </p>
                    </div>
                    <div id="userExperience" class="grid_10 alpha">
                        <?php
                        //explode or split the experience String after each comma, setting an array contain multiple Strings.
                        $experienceExplode = explode(",", $experience);
                        echo '<h2> Experience: </h2>';
                        echo '<ul>';
                        //parse the experience array and setting each String onto each line.
                        for($j = 0; $j !=count($experienceExplode);$j++){
                            echo '<li>'.$experienceExplode[$j].'</li>';
                        }

                        echo '</ul>';
                        ?>
                    </div>

                </div>
                <div id="userEducation" class="grid_4 alpha">
                    <?php
                    echo '<h2> Education: </h2>';
                    //explode or split the education String after each comma, setting an array contain multiple Strings.
                    $educationExplode = explode(",",$education);
                    //parse the education array and setting each String onto each line.
                    for($i = 0; $i!=count($educationExplode); $i++){
                        echo '<p>'.$educationExplode[$i].'</p>';
                    }
                    ?>
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