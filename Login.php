<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST['Username']);
    $Password = mysqli_real_escape_string($Connection, $_POST['Password']);

    if (empty($Username) || empty($Password)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled";
        Redirect_to("Login.php");
    } else {
        $FoundAccount = Login_Attempt($Username, $Password);

        if ($FoundAccount) {
            $_SESSION["User_id"] = $FoundAccount["id"];
            $_SESSION["Username"] = $FoundAccount["username"];
            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]}";
            Redirect_to("dasboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Invalid Username / Password";
            Redirect_to("Login.php");
        }
    }

}
?>      
        
    

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="bootstrap/js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
        <title>Login</title>
        <style>
            body{
                background-color: white;
            }
        </style>
        
    </head>
    <body>
    <div style="height: 10px; background: #27aae1;"></div>
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 
                    <a href="Blog.php">
                        <h3 style="color: white;">ShareTech</h3>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav" style="margin-left: 60px;font-size: 20px;">
                    <li class=""><a href="Blog.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    
                    
                </ul>
                </div>
            </div>
        </nav>
        <div style="height: 10px; background: #27aae1;margin-top: -20px;"></div>
    <div class="container-fluid">
            <div class="row">
                
                <div class="col-sm-offset-4 col-sm-4">
                    <br><br><br><br><br>
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <h1>Welcome </h1>
                    
                    <div>
                        <form action="Login.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label for="Username"><span class="FieldInfo">UserName:</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-envelope text-info"></span>
                                        </span>
                                        <input class="form-control"type="text" name="Username" id="Username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Password"><span class="FieldInfo">Password:</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock text-info"></span>
                                        </span>
                                        <input class="form-control"type="password" name="Password" id="Password" placeholder="Password">
                                
                                    </div>
                                </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" name="Submit" value="Login">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
        
        
    </body>
</html>
