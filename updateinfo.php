<?php
ob_start();
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
    exit();

}
$user=$currentUser['id'];
 if(isset($_POST['save_info']))
 {
        $des=$_POST['describe'];
        //update
        $Relationship_Status=$_POST['Relationship_status'];
        $Live=$_POST['Lives'];
        $Gender=$_POST['Gender_'];
        $displayName = $_POST['displayName'];
        $numberPhone=$_POST['numberPhone'];
        $birthday=$_POST['birthday'];
       
        // $birthday=$_POST['birthday'];
            if(isset($_POST['save_info']))
            {
            
                        updateUserMyProfile($currentUser['id'],$des,$Relationship_Status,$Live,$Gender);
                        updateUserProfile($currentUser['id'],$displayName,$numberPhone,$birthday);
                        header("Location: profile.php?id=$user"); 

            } 
        
 }
 if(isset($_POST['insertinfo']))
 {
      //insert
    $des_insert=$_POST['describe_insert'];
    $Relationship_Status_insert=$_POST['Relationship_status_insert'];
    $Live_insert=$_POST['Lives_insert'];
    $Gender_insert=$_POST['Gender_'];
     if (isset($_POST['insertinfo']))
    {
     
        insert_info_profile($currentUser['id'],$des_insert,$Relationship_Status_insert,$Live_insert,$Gender_insert);
          header("Location: profile.php?id=$user"); 
     }

 }
?>
<?php
    echo "<script>alert('cập nhật thất bại')</script>";
     echo "<script>window.open('profile.php?id=$user','_self')</script>";
 ?>