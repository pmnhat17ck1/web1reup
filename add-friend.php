<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
   exit();
}
$userId=$_POST['id'];
$profile=findUserByID($userId);
$content="đang theo dõi";
$name=$currentUser['displayName'];
$idcurrent=$currentUser['id'];
if(isset($_POST['btnclickSend'])){
    sendFriendRequest($currentUser['id'],$profile['id'],0);
    upnotice($userId,null,$content);
        $td = "Yêu cầu kết bạn";
        $nd = "Bạn nhận được lời mời kết bạn từ $name <a href=\"$BASE_URL/profile.php?id=$idcurrent\">$BASE_URL/profile.php?id=$idcurrent </a> ";
        sendEmail($profile['email'], $profile['displayName'], $td, $nd);
 
}
else if(isset($_POST['btnclickAccpet'])){
    updateFriendRequest($profile['id'],$currentUser['id'],1);
    sendFriendRequest($currentUser['id'],$profile['id'],1);
}
header('Location: profile.php?id='.$_POST['id']);