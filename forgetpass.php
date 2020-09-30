<?php
 require_once 'init.php';
//require 'functions.php';
?>

<?php
    include 'header.php';
?>
<section class="container-fluid" style="background-color: #E9EBEE; padding :100px">
    <section class="row justify-content-center">
        <section>
<?php if(isset($_GET['email'])): ?>
<?php 
$email = $_GET['email'];
$success = false;
$user = findUserByEmail($email);
if($user && $user['status'] == 1)
{
    
    $success =ForgetPassword($user['id'], $user['displayName'], $user['email'], $user['password']);
}

?>
<?php if ($success): ?>
    <br>
    <br>
    <div class="alert alert-success" role="alert">
            Vui lòng kiểm tra email để lấy mật khẩu mới!
    </div>
<?php else : ?>
<div class ="alert alert-danger" role="alert"> Không tìm thấy email của bạn!</div>
<?php endif; ?>
<?php else : ?>
    <h1><center>Quên mật khẩu</center></h1>
    <form method="GET">
    <div class ="form-group">
        <div class="card"style="width:350px">
            <div class="card-body">
            <label for="email">Email</label>
            <input type="email" class ="form-control" id ="email" name ="email" placeholder="Email">
            </div>
            <br>
            <button type = "submit" class = "btn btn-primary">Lấy mật khẩu mới</button>
        </div> 
        </div>   
    </form>
        </section>
    </section>
</section>
<?php endif; ?>
<?php include 'footer.php'; ?>