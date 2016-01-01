

<?php
session_start();

if (!$_SESSION['employer']) {
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
    </head>
    <body>
        <?php
        try {
            ini_set("display_errors", 1);




            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            // gets the user id and searches for a matching id in the member table and displays the user's details
            $sTable = new seekerTable($connection);
            $aTable = new applicationTable($connection);
            $jTable = new jobsTable($connection);

            $id = $_SESSION['id'];
            $applicants = $aTable->showAll();
            $duplicate = false;


            $saveNum = $_GET['saveNum'];

            $count = $saveNum;
            $limit = $count + 10;
            $loopPass = 0;
            $previousSaveNum = $saveNum - 10;


            $seekers = $sTable->showAll();
            $jobs = $jTable->showAll();
        } catch (PODException $e) {
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
                    <div id="formWrap">
                        <legend><h1>Applicants</h1></legend>
                        <?php
                        echo '<table class="table">';
                        echo '<tr>';
                        echo ' <th> Applicant </th> '
                        . ' <th> Applied For: </th> '
                        . '<th> Remove </th>';

                        echo '</tr>';

                        foreach ($applicants as $applicant) {
                            foreach ($jobs as $job) {
                                foreach ($seekers as $seeker) {
                                    //check if the application's seeker id matches the seeker's id, the applicant's employer id matches the current employer's id and that the application's job id matches the looped job id.
                                    if ($applicant->getSeekerId() == $seeker->getId() && $applicant->getEmpId() == $id && $applicant->getStatus() == 1 && $applicant->getJobId() == $job->getId()) {
                                       
                                        if ($count < $limit && $loopPass == $count) {
                                            echo ' <td><a href="resume.php?id=' . $seeker->getId() . '"target="blank">' . $seeker->getFName() . ' ' . $seeker->getLName() . '</a> </td>';
                                            echo '<td>' . $job->getTitle() . '</td>';
                                            echo '<td><a href="removeApplicant.php?id=' . $applicant->getId() . '&saveNum=' . $saveNum . '">[REMOVE]</a></td>';
                                            $count++;
                                            $saveNum++;
                                            echo '</tr>';
                                        }
                                        $loopPass++;
                                        
                                    }

                                    $duplicate = true;
                                }
                            }
                        }


                        //if the count value matches the limit value - stop displaying results and display links to the previous and next pages passing the current count value (saveNum).
                        if ($count == $limit) {
                            if ($count > 10) {
                                echo '<td><a href="viewApplicants.php?saveNum=' . $previousSaveNum . '">Previous Page</a></td>';
                                echo '<td> </td>';
                                echo '<td><a href="viewApplicants.php?saveNum=' . $saveNum . '">Next Page</a></td>';
                            } else {
                                echo '<td></td>';
                                echo '<td> </td>';
                                echo '<td><a href="viewApplicants.php?saveNum=' . $saveNum . '">Next Page</a></td>';
                            }
                        }

                        echo '</table>';
                        ?>
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


