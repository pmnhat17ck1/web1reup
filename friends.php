<?php 
  require_once 'init.php';
  if (!$currentUser)
  {
  	header('location: home.php');
  	exit();
  }
	$userId = $_GET['id'];
    $profile = findUserByID($userId);
 // TOTLA FRIENDS
$get_frnd_num = get_all_friends($userId, false);
// GET MY($_SESSION['user_id']) ALL FRIENDS
$get_all_friends = get_all_friends($userId, true);
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Friend</title>
	<style>
		a { font-size:100%;font-family: inherit};	
	</style>		
</head>
<body>
    <br> <br> <br> <br>
	<div class="container">
            <div class="all_users">
            <h3>All friends</h3>
            <div class="usersWrapper">
                        <?php
                        $check=null;
                if($get_frnd_num > 0){
                    foreach($get_all_friends as $row){
                        $checks=$row->picture;
                        echo  $checks!=null ? '<div class="user_box">
                                        <div class="user_img"><a href="profile.php?id='.$row->id.'"</a> <img src="data:image/jpeg;base64,'.base64_encode($row->picture).'" alt="Profile image"></div>
                                        <a href="profile.php?id='.$row->id.'"<div class="user_info"><span>'.$row->displayName.'</span><a href="profile.php?id='.$row->id.'" class="see_profileBtn">See profile</a></div> </a>' : '<div class="user_box">
                                        <div class="user_img"><a href="profile.php?id='.$row->id.'"</a> <img src="avatars/no-avatar.jpg" class="card-img-top;""></div>
                                        <a href="profile.php?id='.$row->id.'"<div class="user_info"><span>'.$row->displayName.'</span><a href="profile.php?id='.$row->id.'" class="see_profileBtn">See profile</a></div> </a>' ;
                 
                    }
                }
                else{
                    echo '<h4>Dont have friends!</h4>';
                }
                ?>
                       </div>
        </div>
	</div>
</body>
</html>
<?php include 'footer.php'; ?>