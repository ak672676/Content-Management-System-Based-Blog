<?php require_once("include/Sessions.php");?>
<?php require_once("include/Functions.php");?>
<?php require_once("include/DB.php");?>
<?php 
    if(isset($_GET['id'])){
        $IdFromURL=$_GET["id"];
        $ConnectingDB;
        $Admin=$_SESSION["Username"];
        $Query="UPDATE comments SET status='ON',approvedby='$Admin' WHERE id='$IdFromURL'";
        $Execute= mysqli_query($Connection,$Query);
        if($Execute){
            $_SESSION["SessionMessage"]="Comment Approved Successfully";
            Redirect_to("Comments.php");
        }
        else{
            $_SESSION["SessionMessage"]="Something went wrong";
            Redirect_to("Comments.php");
        }
        
    }

?>