<?php
    ob_start();
    require_once 'init.php';
?>
<?php
    include 'header.php';
?>
<?php if (!$currentUser):  ?>
<?php if(isset($_POST['displayName']) && isset($_POST['email']) && isset($_POST['password'])&&isset($_POST['numberPhone'])&&isset($_POST['birthday'])): ?>
<?php 
$displayName= $_POST['displayName']; 

$email = $_POST['email'];
$password = $_POST['password'];
$numberPhone=$_POST['numberPhone'];
$birthday=$_POST['birthday'];
$hashPassword = password_hash($password,PASSWORD_DEFAULT);
$success = false;
$user =findUserByEmail($email);
    if(!$user)
    {
        $newUserId=createUser($displayName, $email, $password, $numberPhone,$birthday);
      
            $success =true;
    }
?>
<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        Vui lòng kiểm tra email để kích hoạt tài khoản
    </div>
<?php else : ?>
        <div class ="alert alert-danger" role="alert">Đăng Ký Thất Bại</div>
        <?php 
    echo "<script>alert( 'error!')</script>";
     echo "<script>window.open('register.php','_self')</script>";
     ?>
<?php endif; ?>
<?php else : ?>
    <section class="container-fluid" style="background-color: #E9EBEE; padding :40px">
            <section class="row justify-content-center"><section>
                <h1><center>Đăng ký</center></h1>
                <div class="card"style="width:350px">
                     <div class="card-body">
                 <form action="register.php" method = "POST">

                    <div class = "form-group">
                        <label for="displayName"  ><strong>Họ tên</strong></label>
                        <input type="text" class = "form-control" id = "displayName" name = "displayName" placeholder = "Họ tên" required>
                    </div>

                    <div class = "form-group">
                        <label for="email"  ><strong>Email</strong></label> 
                        <input type="email" class = "form-control" id = "email" name = "email" placeholder = "Email">
                    </div>

                    <div class = "form-group">
                        <label for="password"><strong>Mật Khẩu</strong></label> 
                        <input type="password" class = "form-control" id = "password" name = "password" placeholder = "Mật Khẩu"required>
                    </div>
                    <div class = "form-group">
                        <label for="numberPhone"><strong>Số điện thoại</strong></label> 
                        <input type="numberPhone" class = "form-control" id = "numberPhone" name = "numberPhone" placeholder = "Số điện thoại"required>
                    </div>
                    <div class="form-group>">
                        <label for="birthday"><strong>Ngày sinh</strong></label> 
						<input type="date" name="birthday"id = "birthday" class="form-control input-md" >
					</div><br>
                    <p><button type = "submit"  class = "btn btn-primary">Đăng Ký</button> </p>
                </form>
            </div>
        </div>
        </section>
    </section>
</section>
<?php endif; ?>
<?php else:?>
    <?php echo"<script>window.open('index.php','_self')</script>";?>
<?php endif;  ?>
<?php include 'footer.php';?>