

<?php
session_start();

if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';
require_once 'jobSaveTable.php';
require_once 'applicationTable.php';
require_once 'jobSave.php';
require_once 'jobsTable.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title> Saved Job Applications </title>
    </head>
    <body>
        <?php
        try {
            ini_set("display_errors", 1);




            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            // gets the user id and searches for a matching id in the member table and displays the user's details
            $sTable = new seekerTable($connection);
            $jsTable = new jobSaveTable($connection);
            $jTable = new jobsTable($connection);

            $id = $_SESSION['id'];
            $jobSaves = $jsTable->showAllUnseen();
            $duplicate = false;

            $saveNum = $_GET['saveNum'];
            $count = $saveNum;
            $limit = $count + 10;
            $loopPass = 0;
            $previousSaveNum = $saveNum - 10;


            $jobs = $jTable->showAll();
            $seeker = $sTable->findById($id);
            
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
                    <legend><h1>Saved Job Applications</h1></legend>
                    <?php
                    echo '<table class="table">';
                    echo '<tr>';
                    echo ' <th> Job Title </th>
               <th> Company </th>
               <th> Contract Type </th>
               <th> Remove </th>';

                    echo '</tr>';

                    foreach ($jobSaves as $jobSave) {
                        foreach ($jobs as $job) {
                            if ($jobSave->getJId() == $job->getId() && $jobSave->getSId() == $id) {
                                // if the current count value has not surpassed the limit and that the loopPass value starts at the current count value (to avoid displaying the same 10 results)
                                if ($count < $limit && $loopPass == $count) {
                                    echo ' <td><a href="viewJob.php?jId=' . $job->getId() . '">' . $job->getTitle() . '</a> </td>';
                                    echo ' <td>' . $job->getCompany() . '</td>';
                                    echo '<td> ' . $job->getContractType() . '</td>';
                                    echo '<td><a href="removeSavedApplication.php?saveId=' . $jobSave->getId() . '&saveNum=' . $saveNum . '">[REMOVE]</a></td>';
                                    $count++;
                                    $saveNum++;
                                    echo '</tr>';
                                }
                                $loopPass++;
                                //}
                            }


                            $duplicate = true;
                        }
                    }
                    //if the count value matches the limit value - stop displaying results and display links to the previous and next pages passing the current count value (saveNum).
                    if ($count == $limit) {
                        if ($count > 10) {
                            echo '<td><a href="viewSavedApplications.php?saveNum=' . $previousSaveNum . '">Previous Page</a></td>';
                            echo '<td> </td>';
                            echo '<td><a href="viewSavedApplications.php?saveNum=' . $saveNum . '">Next Page</a></td>';
                        } else {
                            echo '<td></td>';
                            echo '<td> </td>';
                            echo '<td><a href="viewSavedApplications.php?saveNum=' . $saveNum . '">Next Page</a></td>';
                        }
                    }


                    echo '</table>';
                    ?>
                </div>
            </div>



            <div id="footer">
                <div id ="footerBody" class="container_16">

                    <div id="contactInfo" class="grid_6">
                    </div>
                </div>
                </body>
                </html>


