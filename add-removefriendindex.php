<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
   exit();
}
$userId=$_POST['id'];
$profile=findUserByID($userId);
 if(isset($_POST['btnclickAccpetindex'])){
    updateFriendRequest($profile['id'],$currentUser['id'],1);
    sendFriendRequest($currentUser['id'],$profile['id'],1);
    
}
if(isset($_POST['btnclickDelineindex'])){
    removeFriendRequest($currentUser['id'],$profile['id']);
}
header('Location: index.php');