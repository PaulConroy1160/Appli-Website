<?php
session_start();

if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';


try {
    ini_set("display_errors", 1);

    $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

    //gets the user id and searches the member table for matching id
    $id = $_SESSION["id"];
    $table = new seekerTable($connection);
    $seeker = $table->findById($id);
    
    $theme = $seeker->getTheme();
    
    if (isset($_POST['submit'])) {
        $search = filter_var($_POST['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
                    <div id="formWrapSearch">

                        <form class="form-horizontal" action="jobResults.php" enctype="multipart/form-data" method="post">

                            <fieldset>

                                

                                <!-- Search Bar -->
                                <div class="form-group form-group-lg">
                                    <label class="col-md-5 control-label" for="search"></label>  
                                    <div class="col-md-10">
                                        <input id="search" name="search" class="form-control input-lg" type="text" placeholder="Search Jobs..."  value="">
                                    </div>
                                    <div class="col-md-2">
                                        <input type ="image" src="imageRes/searchIcon.png" id="submit" name="submit" ></button>
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


