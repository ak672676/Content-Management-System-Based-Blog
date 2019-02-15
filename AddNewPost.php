<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Title = mysqli_real_escape_string($Connection, $_POST['Title']);
    $Category = mysqli_real_escape_string($Connection, $_POST['Category']);
    $Post = mysqli_real_escape_string($Connection, $_POST['Post']);
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/" . basename($_FILES["Image"]["name"]);
    if (empty($Title)) {
        $_SESSION["ErroeMessage"] = "Title can't be empty";
        Redirect_to("AddNewPost.php");
    } else if (strlen($Title) < 2) {
        $_SESSION["ErroeMessage"] = "Title should be of atleast two characters";
        Redirect_to("AddNewPost.php");
    } else {
        global $ConnectingDB;
        $Query = "INSERT INTO admin_panel(datetime,title,category,author,image,post) VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
        $Execute = mysqli_query($Connection, $Query);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post Added Successfully";
            header("AddNewPost.php");
        } else {
            $_SESSION["ErroeMessage"] = "Something Went Wrong";
            Redirect_to("AddNewPost.php");
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
        <title>Add-New-Post</title>
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
    <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                <br><br>
                    <ul id="side-menu" class="nav nav-pills nav-stacked">
                        <li><a href="dasboard.php"><span class="glyphicon glyphicon-th"> </span>&nbsp;Dashboard</a></li>
                        <li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"> </span>&nbsp;Add New Post</a></li>
                        <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                        
                        <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                        <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                        <li><a href="Blog.php"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                        <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; LogOut</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <h1>Add New Post</h1>
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <div>
                        <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label for="title"><span class="FieldInfo">Title:</span></label>
                                    <input class="form-control"type="text" name="Title" id="title" placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                                    <select class="form-control" id="categoryselect" name="Category">
                                        <?php 
                                        global $ConnectingDB;
                                        $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                                        $Execute = mysqli_query($Connection, $ViewQuery);

                                        while ($DataRows = mysqli_fetch_array($Execute)) {
                                            $Id = $DataRows["id"];
                                            $CategoryName = $DataRows['name'];
                                            ?>
                                        <option><?php echo $CategoryName; ?></option>
                                            <?php 
                                        } ?>
                                            
                                        
             
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                                    <input type="File" class="form-control" name="Image" id="imageselect">
                                </div>
                                <div class="form-group">
                                    <label for="postarea"><span class="FieldInfo">Post:</span></label>
                                    <textarea class="form-control" name="Post" id="postarea"></textarea>
                                </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Post">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                    
            
                            
            
               
            
                       
                    
                </div>
            </div>
        </div>
        <div id="footer">
             © Copyright 2019, All Rights Reserved
        </div>
        
    </body>
</html>
