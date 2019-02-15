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
        <title>ShareTech</title>
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
        <br>
        <div class="container">
            <div class="blog-header">
                
                <div class="jumbotron">
                    <h1 class="display-4" style="text-align:center;">Read Share & Learn !!</h1>
                    <hr class="my-4">
                    <p class="lead" style="text-align:center;">Technical…Practical…Theoretically Interesting</p>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php 

                    global $ConnectingDB;

                    if (isset($_GET["SearchButton"])) {
                        $Search = $_GET["Search"];
                           // echo "<h1>AMIT</h1>";
                        $ViewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
                    } else if (isset($_GET["Category"])) {
                        $Category = $_GET['Category'];
                        $ViewQuery = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY datetime desc";
                    } else if (isset($_GET["Page"])) {
                        $Page = $_GET["Page"];
                        if ($Page == 0 || $Page < 1) {
                            $ShowPostFrom = 0;
                        } else {
                            $ShowPostFrom = ($Page * 5) - 5;
                        }
                        $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $ShowPostFrom,5 ";
                    } else {
                        $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
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
                            <p class="description">Category:<?php echo htmlentities($Category); ?>|Posted On:<?php echo htmlentities($DateTime); ?></p>
                            <p class="post"><?php if (strlen($Post) > 150) {
                                                $Post = substr($Post, 0, 150) . '...';
                                            }

                                            echo $Post; ?></p>
                        </div>
                        <a href="FullPost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">Read More &rsaquo;&rsaquo;</span></a>
                    </div> 
                        <?php 
                    } ?>
                    <nav>
                        <ul class="pagination pull-left pagination-lg">
                        <?php 
                        if (isset($Page)) {
                            if ($Page > 1) {
                                ?> 
                            <li><a href="Blog.php?Page=<?php echo $Page - 1; ?>"> &laquo; </a></li>
                            <?php 
                        }
                    } ?>
                    
                    <?php 
                    $ConnectingDB;
                    $QueryPagination = "SELECT COUNT(*) FROM admin_panel";
                    $ExecutePagination = mysqli_query($Connection, $QueryPagination);
                    $RowPagination = mysqli_fetch_array($ExecutePagination);
                    $TotalPost = array_shift($RowPagination);
                    $PostPerPage = ceil($TotalPost / 5);
                    for ($i = 1; $i <= $PostPerPage; $i++) {
                        if (isset($Page)) {
                            if ($i == $Page) {
                                ?>
                            <li class="active"><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php 
                        } else { ?>
                            <li><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php

                        }
                    } ?>
                        <?php 
                    } ?>
                        <?php 
                        if (isset($Page)) {
                            if ($Page + 1 <= $PostPerPage) {
                                ?> 
                            <li><a href="Blog.php?Page=<?php echo $Page + 1; ?>"> &raquo; </a></li>
                            <?php 
                        }
                    } ?>
                        </ul>   
                    </nav>
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
