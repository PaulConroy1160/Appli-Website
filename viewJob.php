<?php
session_start();

if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'jobsTable.php';
require_once 'seekerTable.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <script src="js/ajaxApplicantRequest.js"></script>
        <title>Job Application</title>
    </head>
    <body onload="ajaxFunction()">
        <?php
        try {
            ini_set("display_errors", 1);

            $id = $_SESSION['id'];
            $fName = $_SESSION['seeker'];
            $jId = $_GET['jId'];


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            // gets the user id and searches for a matching id in the employer table and displays the employer's details
            $table = new jobsTable($connection);
            $sTable = new seekerTable($connection);
            $seeker = $sTable->findById($id);
            $theme = $seeker->getTheme();
            $job = $table->findById($jId);
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
                    <div id="jobViewTable">
                        <legend><h1><?php echo $job->getTitle(); ?></h1></legend>


                        <?php
                        echo '<table class="table">';
                        echo '<tr>';
                        echo ' <th> Salary </th>
               <th> Company </th>
               <th> Contract Type </th>
                <th> Date Posted </th>';

                        echo '</tr>';


                        echo ' <td>' . $job->getRPackage() . ' </td>';
                        echo ' <td>' . $job->getCompany() . '</td>';
                        echo '<td> ' . $job->getContractType() . '</td>';
                        echo '<td> ' . $job->getdate() . '</td>';

                        echo '</tr>';
                        //}





                        echo '</table>';

                        echo '<div id="jDescription">'
                        . '<p> ' . $job->getSummary() . '</p> </div>';

                        echo '<br>';
                        echo '<table class="table">';
                        echo '<tr>';
                        echo ' <th> Experience Required </th>
               <th> Responsibilities </th>';

                        echo '</tr>';


                        echo ' <td>' . $job->getExReq() . ' </td>';
                        echo ' <td>' . $job->getResponsibilities() . '</td>';


                        echo '</tr>';
                        //}





                        echo '</table>';
                        ?>
                        <form class="form-horizontal" action="applyToJob.php" enctype="multipart/form-data" method="post">
                        <div id="appliButton>"
                             <!-- Submit Button -->
                             <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-4">
                                    <button id="appliButton" name="submit" class="btn btn-default">appli</button>
                                    <input type="hidden" name="empId" value="<?php echo $job->getEmpID(); ?>"></input>
                                    <input type="hidden" name="jId" value="<?php echo $job->getId(); ?>"></input>
                                </div>
                            </div>
                        </div>
                        </form>
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