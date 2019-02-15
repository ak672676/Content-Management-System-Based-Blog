<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Username = mysqli_real_escape_string($Connection, $_POST['Username']);
    $Password = mysqli_real_escape_string($Connection, $_POST['Password']);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST['ConfirmPassword']);
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $Admin = $_SESSION["Username"];
    if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled";
        Redirect_to("Admins.php");
    } else if (strlen($Password) < 6) {
        $_SESSION["ErrorMessage"] = "Atleast 6 characters required";
        Redirect_to("Admins.php");
    } else if ($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Password not matching";
        Redirect_to("Admins.php");
    } else {
        global $ConnectingDB;
        $Query = "INSERT INTO registration(datetime,username,password,addedby) VALUES('$DateTime','$Username','$Password','$Admin')";
        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Admin Added Successfully";
            Redirect_to("Admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something Went Wrong";
            Redirect_to("Admins.php");
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
        <title>Manage Admins</title>
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
                        <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"> </span>&nbsp;Add New Post</a></li>
                        <li ><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                        
                        <li class="active"><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                        <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                        <li><a href="Blog.php"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                        <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; LogOut</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <h1>Manage Admin Access</h1>
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <div>
                        <form action="Admins.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label for="Username"><span class="FieldInfo">UserName:</span></label>
                                    <input class="form-control"type="text" name="Username" id="Username" placeholder="Username">
                                 </div>
                                <div class="form-group">
                                    <label for="Password"><span class="FieldInfo">Password:</span></label>
                                    <input class="form-control"type="password" name="Password" id="Password" placeholder="Password">
                                 </div>
                                <div class="form-group">
                                    <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
                                    <input class="form-control"type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Re-type same password">
                                 </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admin">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Sr.No</th>
                                <th>Date & Time</th>
                                <th>Admin Name</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
            <?php 
            global $ConnectingDB;
            $ViewQuery = "SELECT * FROM registration ORDER BY datetime desc";
            $Execute = mysqli_query($Connection, $ViewQuery);
            $SrNo = 0;
            while ($DataRows = mysqli_fetch_array($Execute)) {
                $Id = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $UserName = $DataRows["username"];
                $Admin = $DataRows["addedby"];
                $SrNo++;

                ?>
                            <tr>
                                <td><?php echo $SrNo; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $UserName; ?></td>
                                <td><?php echo $Admin; ?></td>
                                <td><a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo $Id; ?>">Delete</a></td>
                            </tr>
            
                <?php 
            } ?>
            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="footer">
             © Copyright 2019, All Rights Reserved
        </div>
        
    </body>
</html>
