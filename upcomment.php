<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
    exit();
}

if(isset($_GET['type'],$_GET['id']))
{
    $content=$_POST['contents'];
    $userdd=$currentUser['id'];
    $contentprfile=$_POST['contentss'];
    $contents="Vừa mới bình luận bài viết ";
    $type=$_GET['type'];
    $id=(int)$_GET['id'];
    switch($type){
        case'upcommentindex':
            upcomment($currentUser['id'], $id,$content);
            upnotice($currentUser['id'],$id,$contents);
            header('Location: index.php'); 
            break;
        case'upcommentprofile':
            upcomment($currentUser['id'], $id,$contentprfile);
            header("Location: profile.php?id=$userdd");
         break;
    }
}

