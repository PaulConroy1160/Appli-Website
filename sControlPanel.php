<?php
session_start();

//if the session is not the specified seeker session created at login - the user
//will be redirected to the login page
if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <script src="js/ajaxJobSaveRequest.js"></script>
        <title> Control Panel </title>
    </head>
    <body onload="ajaxFunction()">
        <?php
        try {
            ini_set("display_errors", 1);
            
            //set the seeker's id stored in the session.
            $id = $_SESSION['id'];
            //set the seeker's first name stored in the session.
            $fName = $_SESSION['seeker'];
            //default saveNum set to zero.
            $saveNum = 0;


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            //instantiates a seekerTable passing the connection as the parameter.
            $table = new seekerTable($connection);
            
            //$seeker = $table->findById($id);
            //set the seeker's custom theme.
            $theme = $seeker->getTheme();
        } catch (PODException $e) {
            $connection = null;
            exit("Connection Failed: " . $e->getMessage());
        }
        ?>
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
                    <div id="editResume" class="grid_5">
                        <a href="editResume.php"><img src="imageRes/editResumeIconFinal.png"></a>
                    </div>
                    <div id="savedJob" class="grid_5">
                        <div id='notification'></div>
                        <div id="saveNotifications"><p></p></div>
                        <a href="viewSavedApplications.php?saveNum=<?php echo $saveNum ?>"><img src="imageRes/savedApplicationsIconFinal.png"></a>
                    </div>

                    <div id="searchJob" class="grid_5">
                        <a href="searchJob.php"><img src="imageRes/searchJobsIconFinal.png"></a>
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