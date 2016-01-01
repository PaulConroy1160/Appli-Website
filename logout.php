<?php
//start the session on this page.
session_start();

//destroy and end the user's session.
session_destroy();

//redirect the user to the login page.
header("Location: login.php");
?>