<?php require_once("include/Sessions.php");?>
<?php require_once("include/Functions.php");?>
<?php require_once("include/DB.php");?>
<?php 
    if(isset($_GET['id'])){
        $IdFromURL=$_GET["id"];
        $ConnectingDB;
        $Query="DELETE FROM category WHERE id='$IdFromURL'";
        $Execute= mysqli_query($Connection,$Query);
        if($Execute){
            $_SESSION["SessionMessage"]="Category Deleted Successfully";
            Redirect_to("categories.php");
        }
        else{
            $_SESSION["SessionMessage"]="Something went wrong";
            Redirect_to("categories.php");
        }
        
    }

?>