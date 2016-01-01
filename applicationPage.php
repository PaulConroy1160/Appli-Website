<?php
session_start();

//if session is not the employer declared at login check page, redirect the user to login page
if (!$_SESSION['employer']) {
    header("location: login.php");
}

//require the following object and table classes
require_once 'DB.php';
require_once 'employerTable.php';
require_once 'employer.php';
require_once 'applicationTable.php';
require_once 'application.php';
require_once 'seekerTable.php';
require_once 'seeker.php';
require_once 'job.php';
require_once 'jobsTable.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/ApplicationStyle.css">
        <script src="js/ajaxNotificationRequest.js"></script>

    </head>
    <!-- ajaxFunction function called once the body loads -->
    <body onload="ajaxFunction()">
        <?php
        try {
            ini_set("display_errors", 1);

             //establish a connection
            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

           //instantiate a new employer,seeker,job and application table, passing the connection details as a parameter
            $table = new employerTable($connection);
            $applicationTable = new applicationTable($connection);
            $seekerTable = new seekerTable($connection);
            $jobsTable = new jobsTable($connection);
            
            //id variable will store the employer id stored in the session
            $id = $_SESSION['id'];
            //find the current employer in the database - store in the employer object
            $employer = $table->findById($id);
            //store all the employers in the
            //$employers = $table->showAll();
            //store all jobs
            $jobs = $jobsTable->showAll();
            
            //store all applications
            $applications = $applicationTable->showAll();
            //store all seekers
            $seekers = $seekerTable->showAll();


            //variables used to store the current employer's information
            $fName = $employer->getFName();
            $lName = $employer->getLName();
            $location = $employer->getLocation();
            $company = $employer->getCompany();
            $bio = $employer->getBio();
            $photo = $employer->getPhoto();
        } catch (PODException $e) {
            //if a problem occurs - close connection.
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
                        <div id='notification'></div>
                        <div id='ajaxDiv'></div>
                        <ul>
                            <li><a href="#">Applications</a></li>
                            <li><a href="#">Search</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
        </div>
        <div id="mainDiv">
            <div id = "mainBody" class="container_16">
                <div id="mainHeader" class="grid_7">
                    <h1> <?php echo $fName; ?> <?php echo $lName; ?></h1>
                    <h3> MICROSOFT </h3>
                    <h3> HR</h3>

                </div>
                <div id="mainPhoto" class="grid_4">
                    <img src="imageRes/<?php echo $photo; ?>" width="240px" height="240px">
                </div>
            </div>
        </div>
        <div id="lowerDiv">
            <div id="lowerBody" class="container_16">
                <div id="userBody" class="grid_16">
                    <div id="applicationList">
                        <p>Applications</p>
                        <?php
                        echo '<table class="table table-hover">';
                        echo '<tr>';
                        echo ' <th> Job Title </th>
                                 <th> Applicant </th>
                                    <th> Seen? </th>';

                        echo '</tr>';
                        
                        //loop through each application object in the applications array
                        foreach ($applications as $application) {
                            //loop through each job object in the jobs array
                            foreach ($jobs as $job) {
                                //loop through each seeker object in the seekers array
                                foreach($seekers as $seeker){
                                    //if the application's empId matches the current employer's id, the application's job is matches the job's id and the application's seeker id matches the seeker id
                                    //print the following information
                                    if ($application->getEmpID() == $id && $application->getJobId() == $job->getId() && $application->getSeekerId() == $seeker->getId()) {

                                        echo ' <td>' . $job->getTitle() . ' </td>';
                                        echo ' <td><a href="resume.php?id='. $seeker->getId() . '">'.$seeker->getFName().'</a></td>';
                                        echo '<td> ' . $application->getStatus() . '</td>';

                                        echo '</tr>';
                                    }
                               }
                            }
                        }
                        echo '</table>';
                        ?>
                    </div>
                </div>
            </div>
            <div id="footer">
                <div id ="footerBody" class="container_16">
                    <div id="customizeBTN" class="grid_10">
                        <form class="btn btn-info" action="#">
                            <input type="submit" value="Customize Résumé">
                        </form>
                    </div>
                    <div id="contactInfo" class="grid_6">
                        <h3>Contact Me</h3>
                        <p>Phone: </p>
                    </div>
                    </body>
                    </html>