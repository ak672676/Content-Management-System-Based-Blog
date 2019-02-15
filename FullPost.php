<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $Name = mysqli_real_escape_string($Connection, $_POST['Name']);
    $Email = mysqli_real_escape_string($Connection, $_POST['Email']);
    $Comment = mysqli_real_escape_string($Connection, $_POST['Comment']);
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $PostId = $_GET["id"];
    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErroeMessage"] = "All fileds must be filled";

    } else if (strlen($Comment) > 500) {
        $_SESSION["ErroeMessage"] = "Maximum of 500 characters are allowed ";

    } else {
        global $ConnectingDB;
        $PostIdFromURL = $_GET["id"];
        $Query = "INSERT INTO comments (datetime,name,email,comment,approvedby,status,admin_panel_id) VALUES('$DateTime','$Name','$Email','$Comment','pending','OFF','$PostIdFromURL')";
        $Execute = mysqli_query($Connection, $Query);

        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Comment Posted Successfully";
            Redirect_to("FullPost.php?id=$PostId");
        } else {
            $_SESSION["ErroeMessage"] = "Something Went Wrong";
            Redirect_to("FullPost.php?id=$PostId");
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
        <link rel="stylesheet" type="text/css" href="css/publicstyle.css">
        <title>Full Blog Post</title>
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
                    
                <li class="active"><a href="Blog.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    
                    <li><a href="Login.php">Login</a></li>
                    
                </ul>
                    <form action="Blog.php" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="Search">
                    </div>
                    <button class="btn btn-default" name="SearchButton">Go</button>
                    </form>
                </div>
            </div>
        </nav>
        <div style="height: 10px; background: #27aae1;margin-top: -20px;"></div>
        <div class="container">
            <div class="blog-header">
               <br><br>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php 

                    global $ConnectingDB;

                    if (isset($_GET["SearchButton"])) {
                        $Search = $_GET["Search"];
                            //echo "<h1>AMIT</h1>";
                        $ViewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
                    } else {
                        $PostIdGetURL = $_GET["id"];
                        $ViewQuery = "SELECT * FROM admin_panel WHERE id='$PostIdGetURL' ORDER BY datetime desc";
                    }
                    $Execute = mysqli_query($Connection, $ViewQuery);
                    while ($DataRows = mysqli_fetch_array($Execute)) {
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Title = $DataRows["title"];
                        $Category = $DataRows["category"];
                        $Admin = $DataRows["author"];
                        $Image = $DataRows["image"];
                        $Post = $DataRows["post"];

                        ?>
                    <div class="blogpost thumbnail">
                        <img class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>">
                        <div class="caption">
                            <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
                            <p class="description">Category: <?php echo htmlentities($Category); ?> |  Posted On: <?php echo htmlentities($DateTime); ?></p>
                            <p class="post"><?php echo nl2br($Post); ?></p>
                                                        
                            
                        </div>
                        
                    </div> 
                        <?php 
                    } ?>
                    <br><br>
                    <span class="FieldInfo"><h2>Comments</h2></span>
                    <?php 
                    $ConnectingDB;
                    $PostIdForComments = $_GET["id"];
                    $ExtractQuery = "SELECT * FROM comments WHERE admin_panel_id='$PostIdForComments' AND status='ON'";
                    $Execute = mysqli_query($Connection, $ExtractQuery);
                    while ($DataRows = mysqli_fetch_array($Execute)) {
                        $CommentDate = $DataRows["datetime"];
                        $CommentName = $DataRows["name"];
                        $Comments = $DataRows["comment"];
                        ?>    
                    <div class="CommentBlock">
                        <img class="pull-left" style="margin-right: 5px;" src="Img/comment.png" alt="" width=70px height=80px/>
                        <p style="font-weight: bold;color: orangered;"><?php echo $CommentName; ?></p>
                        <p class="description"><?php echo $CommentDate; ?></p>
                        <p><?php echo $Comments; ?></p>
                    </div>
                    <br><hr>
                    <?php 
                } ?>
                    <span class="FieldInfo"><h4>Share Your Views</h4></span><br>
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <div>
                        <form action="FullPost.php?id=<?php echo "$PostId"; ?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label for="Name"><span class="FieldInfo">Name:</span></label>
                                    <input class="form-control"type="text" name="Name" id="Name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="Email"><span class="FieldInfo">Email:</span></label>
                                    <input class="form-control"type="Email" name="Email" id="Email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="Commentarea"><span class="FieldInfo">Comment:</span></label>
                                    <textarea class="form-control" name="Comment" id="Commentarea"></textarea>
                                </div>
                                <br>
                                <input class="btn btn-primary btn-default" type="submit" name="Submit" value="Submit">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="col-sm-offset-1 col-sm-3">
                    <h2>About me</h2>
                    <div>
                    <img src="Img/Amit.jpg" class="img-responsive img-circle img-icon" alt="" > 
                    <br>
                    </div>
                    <p>
                    I am Amit Kumar, founder of this blog. I am programming lover from India. I spend most of my time in doing programming and helping other programmers. 
                    </p> 
                    <br>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Categories</h2>
                        </div>
                        <div class="panel-body">
                            <?php
                            global $ConnectingDB;
                            $ViewQuery = "SELECT * FROM category ORDER BY datetime";
                            $Execute = mysqli_query($Connection, $ViewQuery);
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $Id = $DataRows["id"];
                                $Category = $DataRows["name"];
                                ?> 
                            <a href="Blog.php?Category=<?php echo $Category; ?>"><span><?php echo $Category; ?></span></a><br>
                             <?php 
                        } ?>
                        </div>
                        <div class="panel-footer">
                            
                        </div>
                    </div>
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">Recent post</h2>
                        </div>
                        <div class="panel-body">
                             <?php
                            global $ConnectingDB;
                            $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
                            $Execute = mysqli_query($Connection, $ViewQuery);
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $Id = $DataRows["id"];
                                $Title = $DataRows["title"];
                                $DateTime = $DataRows["datetime"];
                                $Image = $DataRows["image"];
                                if (strlen($DateTime) > 11) {
                                    $DateTime = substr($DateTime, 0, 12);
                                }
                                ?>
                            <div style="background-color:#EFFBFB;">
                                <img class="pull-left" style="margin-top: 10px; margin-left: 10px" src="Upload/<?php echo $Image; ?>" width=70; height=70;>
                                <br>
                                <a href="FullPost.php?id=<?php echo $Id; ?>">
                                <p style="margin-left: 90px; font-weight: bold;"><?php echo $Title; ?></p>
                                </a>
                                <br>
                                <p class="description" style="margin-left:90px; margin-top: -10px;"><?php echo $DateTime; ?></p>
                            </div>
                                <?php 
                            } ?>
                            <hr>
                        </div>
                        <div class="panel-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
             © Copyright 2019, All Rights Reserved
        </div>
    </body>
</html>
