<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/DB.php"); ?>
<?php Confirm_Login(); ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="bootstrap/js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
        <title>Dashboard</title>
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
                    
                    <li class=""><a href="Blog.php" target="_blank">Home</a></li>
                    
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
                        <li class="active"><a href="dasboard.php"><span class="glyphicon glyphicon-th"> </span>&nbsp;Dashboard</a></li>
                        <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"> </span>&nbsp;Add New Post</a></li>
                        <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                        
                        <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                        <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
                                <?php 
                                $ConnectingDB;
                                $QueryTotal = "SELECT COUNT(*) FROM comments where status='OFF'";
                                $ExecuteTotal = mysqli_query($Connection, $QueryTotal);
                                $RowsTotal = mysqli_fetch_array($ExecuteTotal);
                                $TotalTotal = array_shift($RowsTotal);
                                if ($TotalTotal > 0) {
                                    ?>
                                    <span class="label label-danger pull-right"> <?php echo $TotalTotal; ?> </span><?php 
                                                                                                                } ?>
                            </a></li>
                        <li><a href="Blog.php"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                        <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; LogOut</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    
                    <h1>Admin Dashboard</h1>
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <div class="table-responsive">
                        <table class="table  table-hover">
                            <tr>
                                <th>No</th>
                                <th>Post Title</th>
                                <th>Date & Time</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Banner</th>
                                <th>Comments</th>
                                <th>Actions</th>
                                <th>Details</th>
                            </tr>
        <?php 
        $ConnectingDB;
        $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime";
        $Execute = mysqli_query($Connection, $ViewQuery);
        $Sr = 0;
        while ($DataRows = mysqli_fetch_array($Execute)) {
            $Id = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Title = $DataRows["title"];
            $Category = $DataRows["category"];
            $Admin = $DataRows["author"];
            $Image = $DataRows["image"];
            $Post = $DataRows["post"];
            $Sr++;
            ?>
                            <tr>
                                <td><?php echo $Sr; ?></td>
                                <td style="color: orangered;"><?php if (strlen($Title) > 20) {
                                                                    $Title = substr($Title, 0, 20);
                                                                }
                                                                echo $Title; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $Admin; ?></td>
                                <td><?php if (strlen($Category) > 8) {
                                        $Category = substr($Category, 0, 8);
                                    }
                                    echo $Category; ?></td>
                                <td><img src="Upload/<?php echo $Image; ?>" width="100px"; height="40px";></td>
                                <td>
                                   <?php 
                                    $ConnectingDB;
                                    $QueryApproved = "SELECT COUNT(*) FROM comments where admin_panel_id='$Id' AND status='ON'";
                                    $ExecuteApproved = mysqli_query($Connection, $QueryApproved);
                                    $RowsApproved = mysqli_fetch_array($ExecuteApproved);
                                    $TotalApproved = array_shift($RowsApproved);
                                    if ($TotalApproved > 0) {
                                        ?>
                                        <span class="label label-success pull-right"> <?php echo $TotalApproved; ?> </span><?php 
                                                                                                                        } ?>
                                    
                                    <?php 
                                    $ConnectingDB;
                                    $QueryUnApproved = "SELECT COUNT(*) FROM comments where admin_panel_id='$Id' AND status='OFF'";
                                    $ExecuteUnApproved = mysqli_query($Connection, $QueryUnApproved);
                                    $RowsUnApproved = mysqli_fetch_array($ExecuteUnApproved);
                                    $TotalUnApproved = array_shift($RowsUnApproved);
                                    if ($TotalUnApproved > 0) {
                                        ?>
                                        <span class="label label-danger pull-left"> <?php echo $TotalUnApproved; ?> </span><?php 
                                                                                                                        } ?>
                                    
                                </td>
                                <td>
                                    <a class="btn btn-info" href="EditPost.php?Edit=<?php echo $Id; ?>"> Edit</a>
                                    <a class="btn btn-danger" href="DeletePost.php?Delete=<?php echo $Id; ?>"> Delete</a>
                                </td>
                                <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-success">Live Preview</span></a></td>
                            </tr>
            <?php 
        } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
             © Copyright 2019 , All Rights Reserved
        </div>
        
    </body>
</html>
