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
        <title>Comment</title>
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
                        <li ><a href="dasboard.php"><span class="glyphicon glyphicon-th"> </span>&nbsp;Dashboard</a></li>
                        <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"> </span>&nbsp;Add New Post</a></li>
                        <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                        
                        <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                        <li class="active"><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                        <li><a href="Blog.php"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                        <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; LogOut</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <div><?php echo Message();
                        echo SuccessMessage(); ?></div>
                    <h1>Un-Approved Comments</h1>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approve</th>
                                <th>Delete Comment</th>
                                <th>Details</th>
                            </tr>
                            <?php
                            $ConnectingDB;
                            $Query = "SELECT * FROM comments WHERE status='OFF' ORDER BY datetime desc";
                            $Execute = mysqli_query($Connection, $Query);
                            $Sr = 0;
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $CommentId = $DataRows['id'];
                                $DateTimeComment = $DataRows['datetime'];
                                $PersonName = $DataRows['name'];
                                $PersonComment = $DataRows['comment'];
                                $CommentPostId = $DataRows['admin_panel_id'];
                                $Sr++;
                                if (strlen($PersonComment) > 18) {
                                    $PersonComment = substr($PersonComment, 0, 18);
                                }
                                if (strlen($PersonName) > 18) {
                                    $PersonName = substr($PersonName, 0, 10);
                                }
                                ?>    
                            <tr>
                                <td><?php echo $Sr; ?></td>
                                <td style="color: purple;"><?php echo $PersonName; ?></td>
                                <td><?php echo $DateTimeComment; ?></td>
                                <td><?php echo $PersonComment; ?></td>
                                <td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approve</span></a></td>
                                <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                <td><a href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank"><span class="btn btn-info">Live Preview</span></a></td>
                            </tr>
                            <?php 
                        }
                        ?>
                        </table>
                    </div>
                    <hr> 
                    <h1>Approved Comments</h1>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approved by</th>
                                <th>Revert Approve</th>
                                <th>Delete Comment</th>
                                <th>Details</th>
                            </tr>
                            <?php
                            $ConnectingDB;
                            $Admin = "Amit";
                            $Query = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime desc";
                            $Execute = mysqli_query($Connection, $Query);
                            $Sr = 0;
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $CommentId = $DataRows['id'];
                                $DateTimeComment = $DataRows['datetime'];
                                $PersonName = $DataRows['name'];
                                $PersonComment = $DataRows['comment'];
                                $ApprovedBy = $DataRows["approvedby"];
                                $CommentPostId = $DataRows['admin_panel_id'];
                                $Sr++;
                                if (strlen($PersonComment) > 18) {
                                    $PersonComment = substr($PersonComment, 0, 18);
                                }
                                if (strlen($PersonName) > 18) {
                                    $PersonName = substr($PersonName, 0, 10);
                                }
                                ?>    
                            <tr>
                                <td><?php echo $Sr; ?></td>
                                <td style="color: purple;"><?php echo $PersonName; ?></td>
                                <td><?php echo $DateTimeComment; ?></td>
                                <td><?php echo $PersonComment; ?></td>
                                <td><?php echo $ApprovedBy; ?></td>
                                <td><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
                                <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                <td><a href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank"><span class="btn btn-info">Live Preview</span></a></td>
                            </tr>
                            <?php 
                        }
                        ?>
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
