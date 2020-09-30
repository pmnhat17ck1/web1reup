<?php
    require_once 'init.php';
    $id = $_GET['id'];
    $users=findUserByID($id);
    header('content-type: image/jpeg');
    echo $users['picture'];