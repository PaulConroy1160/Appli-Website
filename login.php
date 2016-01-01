
<http>
    <head>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/login.css">
        <script type="text/javascript" src="js/loginValidate.js"></script>
        <title>Welcome to appli.</title>
    </head>
    <body>
        <div class="container">
	<div class="login-container">
            <div id="output"></div>
            <div class="avatar">appli.</div>
            <div class="form-box">
                <form method="post" action="checkLogin.php" onsubmit="return validateLogin(this)">
                    <input name="email" type="text" placeholder="Email">
                    <input name="password" type="password" placeholder="Password">                   
                    <button class="btn btn-info btn-block login" type="submit" name="Submit">Login</button>
                    <p>Not a member? <a href="chooseUserType.php">Sign up now!</a></p>
                </form>
            </div>
        </div>
        
</div>
    </body>
</http>
