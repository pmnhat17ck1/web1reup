<?php
ob_start();
require 'init.php';
//require 'functions.php';
?>

<?php
    include 'header.php';
?>
<?php if(isset($_POST['password1'])&&isset($_POST['password2'])): ?>
<?php 

$coded = $_GET['code'];
$id= substr( $coded,0,1 );
$code=substr( $coded,2,10);
$findpass=findUserByID($id);
$currentPassword=$code;
$password = $_POST['password1'];
$password1 = $_POST['password2'];
$success = false;

if(password_verify($currentPassword,$findpass['password']) && ($password != $currentPassword)&&($password == $password1)&&($password1!=$currentPassword))
{
               
            UpdateUserPassword( $id,$password);
               $success =true;
}

?>
<?php if ($success): ?>
<?php         $userss = findUserByID($id);
            $_SESSION['userId']= $userss['id']; ?>
            <?php header('Location: index.php');?>
<?php else : ?>
<div class ="alert alert-danger" role="alert">Đổi mật khẩu thất bại</div>
<?php endif; ?>
<?php else : ?>
<div class="container">
<h1>Đổi mật khẩu</h1>
<div class="card" >
<div class="card-body">
<form method = "POST">
    <div class = "form-group">
    <label for="password"><strong>Mật Khẩu mới</strong></label> 
    <input type="password" class = "form-control" id = "password1" name = "password1" placeholder = "Mật khẩu mới "required>
    </div>
    <div class = "form-group">
    <label for="password"><strong>Mật Khẩu mới (nhập lại)</strong></label> 
    <input type="password" class = "form-control" id = "password2" name = "password2" placeholder = "Nhập lại mật khẩu mới "required>
    </div>

    
    <p><button type = "submit" class = "btn btn-primary">Đổi mật khẩu</button> </p>

    </form>
</div>
</div>
</div>
<?php endif; ?>
<br>
<?php include 'footer.php'; ?>