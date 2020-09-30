<?php
    ob_start();
    require_once 'init.php';
?>
<?php include 'header.php';?>
<section class="container-fluid" style="background-color: #E9EBEE; padding :100px">
    <section class="row justify-content-center">
        <section>
<?php if (!$currentUser):?>
<?php if (isset($_POST['email'])&& isset($_POST['password'])):?>
<?php 
    $email=$_POST['email'];
    $password=$_POST['password'];
    $success=false;

    $user = findUserByEmail($email);

    if ($user && $user['status'] == 1 &&password_verify($password, $user['password'])) {
        $success=true;
        $_SESSION['userId']= $user['id'];
    }
?>
<?php if($success):?>
<?php ob_start();?>
<?php header('Location: index.php'); ?>
<?php else: ?>
    <div class="social">
                <img style="width: 380px;" src="https://cdn.pixabay.com/photo/2017/02/25/23/52/connections-2099068_1280.png">
            </div >
    <!-- <?php 
     echo "<script>alert('Đăng nhập thất bại')</script>";
     echo "<script>window.open('login.php','_self')</script>";
     ?> -->
           <script type="text/javascript">
            $(window).on('load',function(){
                $('#myModal').modal('show');
            });
            </script>
            
                <div class="modal fade bd-example-modal-sm"id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thông báo!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       
                    </div>
                    <div class="alert alert-danger"role="alert">Đăng nhập thất bại</div>
                    <div class="modal-footer">
                        <form action="login.php" method="POST" id="thongbao">
                        <button type="button" onclick="form_submit()" class="btn btn-danger" data-dismiss="modal" >Close</button>
                        </form>
                        <?php if(isset($_POST['click_'])): ?>
                        <?php  echo "<script>window.open('login.php','_self')</script>"; ?>
                        <?php else:?>
                        <?php endif?>
                                <script type="text/javascript">
                                function form_submit() {
                                    document.getElementById("thongbao").submit();
                                }    
                                </script>
                    </div>
                    </div>
                </div>
                </div>
<?php endif; ?>
<?php else: ?>
<h1><center>Đăng nhập</center></h1>
<div class="card"style="width:350px">
  <div class="card-body">
    <form action="login.php" method="POST">
			<div class="form-group">
				<label for="email"><strong>Email</strong></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Tên đăng nhập" min=-100 max=1000 required>				
			</div>
			<div class="form-group">
				<label for="password"><strong>Mật khẩu</strong></label>
				<input type="password" class="form-control" id="password" name="password" placeholder="mật khẩu" min=-100 max=1000 required>	
			</div>
            
            <div class="form-group">
                <div style="text-align: right" >
                <a href ="forgetpass.php"><strong>Quên mật khẩu?</strong></a>
                </div>
            </div>
			<button type="submit" class="btn btn-primary"min=-100 max=100>Đăng nhập</button>
		</form>	
        </div>
</div>
        </section>
    </section>
</section>
<?php endif; ?>
<?php else:?>
    <?php ob_start();?>
    <?php header('Location: index.php'); ?>
<?php endif  ?>
<?php include 'footer.php';?>

