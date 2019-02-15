<?php require_once("include/DB.php");?>
<?php require_once("include/Sessions.php");?>
<?php require_once("include/Functions.php");?>
<?php Confirm_Login(); ?>
<?php
    if(isset($_POST["Submit"])){
        $Title= mysqli_real_escape_string($Connection, $_POST['Title']);
        $Category= mysqli_real_escape_string($Connection, $_POST['Category']);
        $Post= mysqli_real_escape_string($Connection, $_POST['Post']);
        date_default_timezone_set("Asia/Karachi");
        $CurrentTime=time();
        $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        $Admin = "Amit Kumar";
        $Image=$_FILES["Image"]["name"];
        $Target="Upload/".basename($_FILES["Image"]["name"]);
        if(empty($Title)){
            $_SESSION["ErroeMessage"]="Title can't be empty";
            Redirect_to("AddNewPost.php");
        }
        else if(strlen($Title)<2){
            $_SESSION["ErroeMessage"]="Title should be of atleast two characters";
            Redirect_to("AddNewPost.php");
        }
        else{
            global $ConnectingDB;
            $EditId=$_GET['Edit'];
            $Query="UPDATE admin_panel SET datetime='$DateTime',title='$Title',category='$Category',author='$Admin',image='$Image',post='$Post' WHERE id='$EditId'"; 
            $Execute= mysqli_query($Connection,$Query);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
            if($Execute){
                $_SESSION["SuccessMessage"]="Post Updated Successfully";
                Redirect_to("AddNewPost.php");
            }else{
                $_SESSION["ErroeMessage"]="Something Went Wrong";
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
        <title>Edit-Post</title>
    </head>
    <body>
        
    <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    
                    <ul id="side-menu" class="nav nav-pills nav-stacked">
                        <li><a href="dasboard.php"><span class="glyphicon glyphicon-th"> </span>&nbsp;Dashboard</a></li>
                        <li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"> </span>&nbsp;Add New Post</a></li>
                        <li><a href="categoclries.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                        
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp; LogOut</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <h1>Update Post</h1>
                    <div><?php echo Message(); echo SuccessMessage();?></div>
                    <div>
                        <?php 
                            $SearchQueryParameter=$_GET["Edit"]; 
                            $ConnectingDB;
                            $ViewQuery="SELECT * FROM admin_panel WHERE id='$SearchQueryParameter'";
                            $Execute= mysqli_query($Connection, $ViewQuery);
                            while($DataRows= mysqli_fetch_array($Execute)){
                                $TitleUpdate=$DataRows["title"];
                                $CategoryUpdate=$DataRows["category"];
                                $ImageUpdate=$DataRows["image"];
                                $PostUpdate=$DataRows["post"];
                            }
                        ?>
                        <form action="EditPost.php?Edit=<?php echo $SearchQueryParameter;?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label for="title"><span class="FieldInfo">Title:</span></label>
                                    <input value="<?php echo $TitleUpdate;?>" class="form-control"type="text" name="Title" id="title" placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <span class="FieldInfo">Existing Category:</span>
                                    <?php echo $CategoryUpdate;?>
                                    <br> 
                                    <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                                    <select class="form-control" id="categoryselect" name="Category">
                                        <?php 
                                            global $ConnectingDB;
                                            $ViewQuery="SELECT * FROM category ORDER BY datetime desc";
                                            $Execute= mysqli_query($Connection, $ViewQuery);
                                            
                                            while($DataRows=mysqli_fetch_array($Execute)){
                                                $Id = $DataRows["id"];
                                                $CategoryName=$DataRows['name'];
                                         ?>
                                        <option><?php echo $CategoryName; ?></option>
                                            <?php   }  ?>
                                            
                                        
             
                                    </select>
                                </div>
                                <div class="form-group">
                                    <span class="FieldInfo">Existing Image:</span>
                                    <img src="Upload/<?php echo $ImageUpdate;?>" width=150px; height=50px;>
                                    <br> 
                                    <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                                    <input type="File" class="form-control" name="Image" id="imageselect">
                                </div>
                                <div class="form-group">
                                    <label for="postarea"><span class="FieldInfo">Post:</span></label>
                                    <textarea class="form-control" name="Post" id="postarea">
                                        <?php echo $PostUpdate;?>
                                    </textarea>
                                </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" name="Submit" value="Update Post">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                    
            
                            
            
               
            
                       
                    
                </div>
            </div>
        </div>
        <div id="footer">
             © Copyright 2014, All Rights Reserved
        </div>
        
    </body>
</html>
