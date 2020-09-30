<?php
require_once 'init.php';
$usernow=$currentUser['id'];
if(isset($_GET['type'],$_GET['id'])){
    $type=$_GET['type'];
    $id=(int)$_GET['id'];
    switch($type){
        case'like':
            $db1->query("INSERT INTO posts_like (postIdd,userId)
            SELECT {$id},{$currentUser['id']}
            FROM posts
            WHERE EXISTS (
                SELECT id from posts where id = {$id})
            AND NOT EXISTS (
                SELECT like_id from posts_like where userId = {$currentUser['id']}
                and postIdd={$id} )
            Limit 1
            ");
            break;
        case'unlike':
                $db1->query("DELETE FROM posts_like WHERE userId={$currentUser['id']} AND postIdd={$id}
                ");
         break;
    }
}
header("Location: profile.php?id=$usernow");