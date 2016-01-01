<?php
session_start();

//if the session is not the specified employer session created at login - the user
//will be redirected to the login page
if (!$_SESSION['employer']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'employerTable.php';
require_once 'employer.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <script src="js/ajaxApplicantRequest.js"></script>
        <title>Control Panel</title>
    </head>
    <body onload="ajaxFunction()">
        <?php
        try {
            ini_set("display_errors", 1);
            
            //store the employer's id stored in the session.
            $id = $_SESSION['id'];
            //store the employer's first name stored in the session.
            $fName = $_SESSION['employer'];
            //default saveNum is set to zero.
            $saveNum = 0;


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            //instantiates a new employerTable - passing the connection as the parameter.
            $table = new employerTable($connection);
        } catch (PODException $e) {
            //if a problem occurs - close the connection.
            $connection = null;
            exit("Connection Failed: " . $e->getMessage());
        }
        ?>
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
                    <div id="editResume" class="grid_5">
                        <a href="editProfile.php"><img src="imageRes/editprofileIconFinal.png"></a>
                    </div>
                    <div id="savedJob" class="grid_5">
                        <div id='notification'></div>
                        <div id="saveNotifications"> </div>
                        <a href="viewApplicants.php?saveNum=<?php echo $saveNum ?>"><img src="imageRes/viewApplicantsIconFinal.png"></a>
                    </div>

                    <div id="searchJob" class="grid_5">
                        <a href="postJob.php"><img src="imageRes/postJobListingFinal.png"></a>
                    </div>
                </div>
            </div>


            <div id="footer">
                <div id ="footerBody" class="container_16">

                    <div id="contactInfo" class="grid_6">

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>