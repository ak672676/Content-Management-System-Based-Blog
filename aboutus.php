<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="bootstrap/js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/publicstyle.css">
        <title>About</title>
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
                    
                    <li ><a href="Blog.php">Home</a></li>
                    <li class="active"><a href="aboutus.php">About Us</a></li>
                    
                    <li><a href="Login.php">Login</a></li>
                </ul>
                    
                </div>
            </div>
        </nav>
        <div style="height: 10px; background: #27aae1;margin-top: -20px;"></div>
        <br>
        <div class="container">
            <div>
                  <h1>About</h1>
                  <br>
                  <img src="Img/Amit.jpg" class="img-responsive img-circle img-icon" alt="" > 
                  <br>
                    
                  <p><em>ShareTech</em> was started in the year 2018 with an intention to help other students who are learning or thinking to learn programming. It is specially for beginners.
                  </p>
                  <p>This blog is related to programming technologies like C, C++, Java,Javascript, Python, PHP, SQL, Android,OpenCV etc. It contains basic programs, tutorials .
                  </P>
            </div>
        </div>
        <br><br><br><br><br><br><br>
        <div style="text-align:center;">
        <h5>Contact Us:  Amit Kumar  |  sharetech@gmail.com</h5>
        </div>
        <div id="footer">
             © Copyright 2019, All Rights Reserved
        </div>
    </body>
</html>
