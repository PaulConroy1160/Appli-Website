<?php


require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'seeker.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/960_16_col.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/pageStyle.css">
        <script type="text/javascript" src="js/SignUpValidateSeeker.js"></script>
        <title>Sign Up Seeker</title>
    </head>
    <body>
        <?php
        try {
            ini_set("display_errors", 1);

            


            $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

            // gets the user id and searches for a matching id in the member table and displays the user's details
            $table = new seekerTable($connection);
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

                        </div>
                    </div>
            </div>
            <div id="controlPanelMain">
                <div id = "mainBody" class="container_16">


                    <div id="formWrap">

                        <form class="form-horizontal" action="addSeeker.php" onsubmit="return validateSignUp(this)" enctype="multipart/form-data" method="post">
                            
                            <fieldset>

                                <!-- Form -->
                                <legend><h1>Sign Up as a Seeker</h1></legend>

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="firstName">First Name</label>  
                                    <div class="col-md-6">
                                        <input id="fName" name="fName" placeholder="First Name" class="form-control input-md" type="text">

                                    </div>
                                </div>

                                <!-- Surname -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="surname">Surname</label>  
                                    <div class="col-md-6">
                                        <input id="surname" name="surname" placeholder="Surname" class="form-control input-md" type="text">

                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email">Email</label>  
                                    <div class="col-md-6">
                                        <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text">

                                    </div>
                                </div>
                                
                                <!-- Password -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="password">Password</label>  
                                    <div class="col-md-6">
                                        <input id="password" name="password" placeholder="password" class="form-control input-md" type="password">

                                    </div>
                                </div>

                                <!-- Bio -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="bio">Bio</label>
                                    <div class="col-md-6">                     
                                        <textarea class="form-control" id="bio" name="bio" placeholder="Short description about yourself. You can edit this later."></textarea>
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
        </div>


        <div id="footer">
            <div id ="footerBody" class="container_16">

                <div id="contactInfo" class="grid_6">
                </div>
                </body>
                </html>