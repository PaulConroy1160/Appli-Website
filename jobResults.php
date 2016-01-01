

<?php
session_start();

if (!$_SESSION['seeker']) {
    header("location: login.php");
}

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';
require_once 'jobsTable.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <title>Job Listings</title>
    </head>
    <body>
        <?php
        try {
            ini_set("display_errors", 1);

            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            //instantiates the seeker and job tables, passing the connection details.
            $sTable = new seekerTable($connection);
            $jTable = new jobsTable($connection);
            
            
            //variable used to store the seeker id stored in the seeker session.
            $id = $_SESSION['id'];
            //find relevant seeker using the id.
            $seeker = $sTable->findById($id);
            //store all jobs in an array.
            $jobs = $jTable->showAll();
            //store the seeker's custom theme.
            $theme = $seeker->getTheme();
            
            //store the search keyword.
            $result = $_POST['search'];
            
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
                    <div id="table">
                    <legend><h1>Job Listings</h1></legend>
                    
                    <?php
                    echo '<table class="table">';
                    echo '<tr>';
                    echo ' <th> Job Title </th>
                            <th> Company </th>
                               <th> Contract Type </th>';

                    echo '</tr>';
                    


                    foreach ($jobs as $job) {
                        //converts the job title and search Strings  into upper case Strings and compares them.
                        if (strpos(strtoupper($job->getTitle()), strtoupper($result)) !== false) {
                            //if they match, echo that job's information.
                            echo ' <td><a href="viewJob.php?jId='.$job->getId().'">' . $job->getTitle() . '</a> </td>';
                            echo ' <td>' . $job->getCompany() . '</td>';
                            echo '<td> ' . $job->getContractType() . '</td>';

                            echo '</tr>';
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
            </div>
    </body>
</html>


