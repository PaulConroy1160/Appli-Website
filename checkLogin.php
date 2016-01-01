<?php

session_start();

require_once 'DB.php';
require_once 'seekerTable.php';
require_once 'employerTable.php';

//Set and sanitize the user inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pass = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//if data has been set
if ($email && $pass) {
    try {
        ini_set("display_errors", 1);
        ob_start();

        $connection = DB::getConnection(DB::host, DB::database, DB::user, DB::password);

        $seekerTable = new seekerTable($connection);
        $employerTable = new employerTable($connection);

        $seekers = $seekerTable->showAll();
        $employers = $employerTable->showAll();

        


        foreach ($seekers as $seeker) {
            $dbSeekerEmail = $seeker->getEmail();
            $dbPassWord = $seeker->getPassword();
            $dbSeekerName = $seeker->getFName();
            $dbTheme = $seeker->getTheme();
            $dbId = $seeker->getId();
            // if match has been found, session will be created with the user's username (first name) ELSE return to login page
            if ( strpos(strtoupper($email), strtoupper($dbSeekerEmail)) !== false && $pass == $dbPassWord) {
                $_SESSION['seeker'] = $dbSeekerName;
                $_SESSION['id'] = $dbId;
                $_SESSION['theme'] = $dbTheme;
                header("Location: sControlPanel.php");
                die();
            }
        }

        foreach ($employers as $employer) {
            $dbEmployerEmail = $employer->getEmail();
            $dbEmployerName = $employer->getFName();
            $dbPassWord = $employer->getPassword();
            $dbId = $employer->getId();
            // if match has been found, session will be created with the user's username (first name) ELSE return to login page
            if (strpos(strtoupper($email), strtoupper($dbEmployerEmail)) !== false && $pass == $dbPassWord) {
                $_SESSION['employer'] = $dbEmployerName;
                $_SESSION['id'] = $dbId;
                header("Location: eControlPanel.php");
                die();
            }
        }



        header("location: login.php");
    } catch (PDOException $e) {
        $connection = null;
        exit("Connection failed: " . $e->getMessage());
    }
} else {
    echo "youre not in";
}
?>