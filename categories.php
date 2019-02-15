<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
    $Category = mysqli_real_escape_string($Connection, $_POST['Category']);
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $Admin = $_SESSION["Username"];
    if (empty($Category)) {
        $_SESSION["ErroeMessage"] = "All Fields must be filled";
        Redirect_to("Categories.php");
    } else if (strlen($Category) > 99) {
        $_SESSION["ErroeMessage"] = "Too long Name";
        Redirect_to("Categories.php");
    } else {
        global $ConnectingDB;
        $Query = "INSERT INTO category(datetime,name,creatorname) VALUES('$DateTime','$Category','$Admin')";
        $Execute = mysqli_query($Connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Category Added Successfully";
            Redirect_to("Categories.php");
        } else {
            $_SESSION["ErroeMessage"] = "Category Failed to add";
            Redirect_to("Categories.php");
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
        <title>Categories</title>
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
                        <li class="active"><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                        
                        <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                        <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                        <li><a href="Blog.php"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                        <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; LogOut</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <h1>Manage Categories</h1>
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <div>
                        <form action="categories.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label for="categoryname"><span class="FieldInfo">Name:</span></label>
                                    <input class="form-control"type="text" name="Category" id="categoryname" placeholder="Name">
                                 </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Category">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Sr.No</th>
                                <th>Date & Time</th>
                                <th>Category</th>
                                <th>Creator Name</th>
                                <th>Action</th>
                            </tr>
            <?php 
            global $ConnectingDB;
            $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
            $Execute = mysqli_query($Connection, $ViewQuery);
            $SrNo = 0;
            while ($DataRows = mysqli_fetch_array($Execute)) {
                $Id = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $CategoryName = $DataRows["name"];
                $CreatorName = $DataRows["creatorname"];
                $SrNo++;

                ?>
                            <tr>
                                <td><?php echo $SrNo; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $CategoryName; ?></td>
                                <td><?php echo $CreatorName; ?></td>
                                <td><a class="btn btn-danger" href="DeleteCategory.php?id=<?php echo $Id; ?>">Delete</a></td>
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
