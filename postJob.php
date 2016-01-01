<?php
//start session
session_start();

//if the session is not the specified employer session created at login - the user
//will be redirected to the login page
if (!$_SESSION['employer']) {
    header("location: login.php");
}

//require necessary classes and tables
require_once 'DB.php';
require_once 'employerTable.php';
require_once 'employer.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <script type="text/javascript" src="js/PostJobValidate.js"></script>
    </head>
    <body>
        <?php
        try {
            ini_set("display_errors", 1);

            //set the employer's id that is stored in the session.
            $id = $_SESSION['id'];
            //set the employer's first name that is stored in the session.
            $fName = $_SESSION['employer'];


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            //instantiates a new employer table - passing the connection as the parameter.
            $table = new employerTable($connection);
            //find the relevant employer using the stored employer's id.
            $employer = $table->findById($id);
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
                            <h1>appli.</h1>
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

                        <form class="form-horizontal" action="addJob.php" onsubmit="return validateJobPost(this)" enctype="multipart/form-data" method="post">

                            <form class="form-horizontal">
                                <fieldset>

                                    <!-- Form -->
                                    <legend><h1>Post Job Listing</h1></legend>

                                    <!-- Job Title -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="jobTitle">Job Title</label>  
                                        <div class="col-md-6">
                                            <input id="jobTitle" name="title" placeholder="Job Title" class="form-control input-md" type="text">

                                        </div>
                                    </div>

                                    <!-- Company -->
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <input id="company" name="company" type="hidden" value="<?php echo $employer->getCompany() ?>">
                                        </div>
                                    </div>

                                    <!-- Remuneration Package -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="remunerationPackage">Remuneration Package</label>  
                                        <div class="col-md-6">
                                            <input id="remunerationPackage" name="rPackage" placeholder="Salary and benefits" class="form-control input-md" type="text">

                                        </div>
                                    </div>

                                    <!-- Job Summary -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="jobSummary">Job Summary</label>
                                        <div class="col-md-6">                     
                                            <textarea class="form-control" id="summary" name="summary" placeholder="Short description of job"></textarea>
                                        </div>
                                    </div>

                                    <!-- Experience Required -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="experience">Experience</label>
                                        <div class="col-md-6">                     
                                            <textarea class="form-control" id="experience" name="experience" placeholder="Brief Experience required for the job"></textarea>
                                        </div>
                                    </div>

                                    <!-- Responsibilities -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="responsibilities">Responsibilities</label>
                                        <div class="col-md-6">                     
                                            <textarea class="form-control" id="responsibilities" name="responsibilities" placeholder="Details of responsibilities applicants will have"></textarea>
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="location">Location</label>  
                                        <div class="col-md-6">
                                            <input id="location" name="location" placeholder="Location" class="form-control input-md" type="text">

                                        </div>
                                    </div>

                                    <!-- Contract type -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="contractType">Contract Type</label>  
                                        <div class="col-md-6">
                                            <input id="contractType" name="contract" placeholder="Contract Type" class="form-control input-md" type="text">

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
            </div>
    </body>
</html>