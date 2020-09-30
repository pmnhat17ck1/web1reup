
<?php
require_once 'init.php';
ob_start(); 
$avatar=$currentUser['picture'];
$covers=$currentUser['cover'];
if(!$currentUser){
    header('Location: index.php');
  
}
$userId=$_GET['id'];
$profile=findUserByID($userId);
$usersinfo=findInfoUserByID($userId);
$postsprofile=getNewfeedsinprofile($userId);
$isFollowing =getFriendship($currentUser['id'],$userId);
$isFollower =getFriendship($userId,$currentUser['id']);
$get_frnd_num = get_all_friends($userId, false);
$get_all_friends = get_all_friends($userId, true);
?>

<?php
    include 'header.php';
?>
<?php 
$userprofile=$profile['displayName'];
$des=$usersinfo['user_describe'];
$status=$usersinfo['Relationship_Status'];
$Live=$usersinfo['Lives_In'];
$numberPhone=$profile['numberPhone'];
$Gender=$usersinfo['Gender'];
$birthday=$profile['birthday'];
$date=date_create($birthday);
$dateformat=  date_format($date,"d/m/y"); 
?>
<?php if(isset($_POST['uploadclick'])||isset($_POST['save_pic'])||isset($_POST['upstatus_profile'])||isset($_POST['save_info'])):?>
<?php 
 $success=false;
  if(isset($_FILES['cover'])) {
    $FILES =$_FILES['cover'];
    $fileName = $FILES['name'];
    $fileSize = $FILES['size'];
    $fileTemp = $FILES['tmp_name'];
      $newImage1 = resizeImage($fileTemp, 250, 250);
      ob_start();
      imagejpeg($newImage1);
      $covers=ob_get_contents();
      ob_end_clean();
      updateCover($currentUser['id'],$covers);
      $success=true;

  }
  if(isset($_FILES['avatar'])) {
    $FILES =$_FILES['avatar'];
    $fileName = $FILES['name'];
    $fileSize = $FILES['size'];
    $fileTemp = $FILES['tmp_name'];
      $newImage = resizeImage($fileTemp, 250, 250);
      ob_start();
      imagejpeg($newImage);
      $avatar=ob_get_contents();
      ob_end_clean();
      updateAvatar($currentUser['id'],$avatar);
      $success=true;

  }
  if(isset($_POST['upstatus_profile'])){
    $content=$_POST['content'];
    $prioty1=$_POST['priority1'];
    $check1 = getimagesize($_FILES["picture_post_icon1"]["tmp_name"]);
    if($check1 !== false) {
      $FILES =$_FILES['picture_post_icon1'];
      $fileName = $FILES['name'];
      $fileSize = $FILES['size'];
      $fileTemp = $FILES['tmp_name'];
        $newImage = resizeImage($fileTemp, 350, 300);
        ob_start();
        imagejpeg($newImage);
        $postImage=ob_get_contents();
        ob_end_clean();
        upstatus($currentUser['id'],$content,$postImage,$prioty1);
        $success=true;
    }else {
      $postImage=null;
      upstatus($currentUser['id'],$content,$postImage,$prioty1);
     $success=true;
  }
}
?>
<?php if ($success): ?>
<?php echo "<script>window.open('profile.php?id=$userId','_self')</script>"; ?>
<?php else : ?>
<div class ="alert alert-danger" role="alert">cập nhật thông tin thất bại</div>
<?php endif ?>
<?php else: ?>
<div class="container">
    <div class="cover">
        <div class="row">
	        	<div class="col-sm-12">
                      <div class="well">
                            <?php if($profile['cover']): ?>
                              <img src="cover.php?id=<?php echo $profile['id']?>" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                      
                            <?php else: ?>
                              <img src="cover/default_cover.jpg" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <?php endif ?>
                            <?php if($isFollowing && $isFollower): ?>
                                          <div class="alert alert-primary" role="alert"style="position: absolute; right:150px;bottom:-7px; height:38px;">
                                             <strong style="position: relative;bottom:7px">Bạn bè</strong>
                                          </div>
                                          <button style="position: absolute; right:260px;bottom:10px"class="btn btn-light"><a href="conversation.php?id=<?php echo $profile['id'];?>"><span style="color:dimgrey" class='fab fa-facebook-messenger'><b style="color:dark"> Nhắn tin</b></span></a></button>
                                          <form method="POST" action="remove-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px"> Hủy bạn bè </button>
                                          </form>
                                      <?php else: ?>
                                      <?php if ($isFollowing && !$isFollower):?>
                                        <button style="position: absolute; right:200px;bottom:10px"class="btn btn-light"><a href="conversation.php?id=<?php echo $profile['id'];?>"><span style="color:dimgrey" class='fab fa-facebook-messenger'><b style="color:dark"> Nhắn tin</b></span></a></button>
                                          <form method="POST" action="remove-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px"> Xóa yêu cầu kết bạn </button>
                                          </form>
                                      <?php endif ?>
                                      <?php if (!$isFollowing && $isFollower):?>
                                        <button style="position: absolute; right:420px;bottom:10px"class="btn btn-light"><a href="conversation.php?id=<?php echo $profile['id'];?>"><span style="color:dimgrey" class='fab fa-facebook-messenger'><b style="color:dark"> Nhắn tin</b></span></a></button>
                                          <form method="POST" action="remove-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px"> Hủy yêu cầu kết bạn </button>
                                          </form>
                                          <form method="POST" action="add-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary" name="btnclickAccpet"  style="position: absolute; right:200px;bottom:10px">Đồng ý yêu cầu kết bạn </button>
                                          </form>
                                      <?php endif ?>
                                      <?php if (!$isFollower && !$isFollowing):?>
                                          <?php if($profile['id']==$currentUser['id']):?>
                                          <?php else: ?>
                                            <button style="position: absolute; right:200px;bottom:10px"class="btn btn-light"><a href="conversation.php?id=<?php echo $profile['id'];?>"><span style="color:dimgrey" class='fab fa-facebook-messenger'><b style="color:dark"> Nhắn tin</b></span></a></button>
                                          <form method="POST" action="add-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary" name="btnclickSend" id="btnclickSend" style="position: absolute; right:20px;bottom:10px">Gửi yêu cầu kết bạn</button>
                                          </form>
                                          <?php endif ?>
                                      <?php endif ?>
                                  <?php endif ?>
                        </div>
                  
                    <?php if($profile['picture']):?> 
                    <img src="avatar.php?id=<?php echo $profile['id']?>" alt="Avatar" class="img-raised rounded-circle img-fluid border border-info"style="height: 174px; width: 170px;">
                    <?php else: ?>
                    <img src="avatars/no-avatar.jpg" alt="Avatar" class="img-raised rounded-circle img-fluid border border-info"style="height: 174px; width: 170px";>
                    <?php endif ?>
                    <?php if ($currentUser['id']!=$profile['id']) :?>
                    <?php else:?>
                    <form action="profile.php?id=<?php echo $currentUser['id']?>" method="post" enctype="multipart/form-data">
                      <ul class="nav pull-left" style="position: absolute;top: 10px;left: 50px;">
                          <li class="dropdown"style="opacity: 0.5;filter: alpha(opacity=50);">
                              <button class="dropdown-toggle btn btn-secondary" data-toggle="dropdown">Change Cover</button> 
                              <div class="dropdown-menu"style="width:300px;height: 150px">
                                <center>
                                <p><strong>Select Cover</strong> and then click the <br> <strong>Update Cover
                                <label class='btn btn-info'style="width:300px;">
                                <input type='file' name='cover' size='60' />
                                </label>
                                <button name='uploadclick' class='btn btn-info'>Update</button>
                                </strong></p>
                                  
                                  </center>
                                </div>
                            </li>
                        </ul>
                    </form>
                    <?php endif?>
                  </div>
                </div>
            </div>
    <div class="row">
        <div class="col-sm-12">
          <div class="well">
            <center><h1 style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><strong>Bambo social</strong></h1></center>
          </div>
        </div>
      </div>
      <div class="row">
            <div class="col-sm-4" style="border-radius: 5px;">
                      
                <div class="card"style="height :670px" >
                    <div class="card-body">
                    <?php if ($currentUser['id']!=$profile['id']) :?>
                    <?php else:?>
                      <form method = "POST" enctype="multipart/form-data"action="profile.php?id=<?php echo $currentUser['id']?>"  >
                      <ul class="nav pull-left" style="position: absolute;bottom: 730px;left: 111px;">
                          <li class="dropdown"style="opacity: 0.8;filter: alpha(opacity=50);">
                              <button class="dropdown-toggle btn btn-secondary" data-toggle="dropdown"><img src="icon/camera.png" alt="avatar" style="width: 25px;height: 25px"></button> 
                              <div class="dropdown-menu"style="width:200px;height: 180px;">
                                <center>
                                <p><strong>Select avatar</strong> and then click the <br> <strong>Update avatar
                                <label class='btn btn-info'style="width:200px;">
                                <input type='file' id="avatar"name="avatar" size='60' />
                                </label>
                                <button name='save_pic' class='btn btn-info'>Update</button>
                                </strong></p>
                                  </center>
                                </div>
                            </li>
                        </ul>
                        </form>
                      <?php endif?>
                
                        <!-- Sua -->
                        <?php if ($currentUser['id']!=$profile['id']) :?>
                        <?php else:?>
                        <?php if(!$userinfo['id']):?>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Sửa
                              </button>
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Thông tin cá nhân</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <div aria-hidden="true">&times;</div>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method = "POST" enctype="multipart/form-data"action="updateinfo.php"  >
                                          <div class="card-body";>
                                              <div class="row">
                                                <div class="col-md-6"style="left:auto;right:auto" >
                                        
                                              <div class = "form-group">
                                                  <label for="describe_insert"  ><strong>Describe </strong></label> 
                                                  <input type="text" class = "form-control" id = "describe_insert" name = "describe_insert" placeholder="describe" >
                                              </div>

                                              <div class = "form-group">
                                                  <label for="Relationship_status_insert"  ><strong>Relationship status</strong></label> 
                                                  <input type="text" class = "form-control" id = "Relationship_status_insert" name = "Relationship_status_insert"placeholder="Relationship status"  >
                                              </div>
                                              <p><button name="insertinfo" class = "btn btn-primary">insert</button> </p>   
                                              </div>
                                             
                                              <div class="col-md-6"style="left:auto;right:auto">
                                              <div class = "form-group">
                                                  <label for="Lives_insert"><strong>Lives In</strong></label> 
                                                  <select class="form-control" name="Lives_insert" >
                                                    <option disabled>Select a Country</option>
                                                    <option>Vietnam</option>
                                                    <option>United States of America</option>
                                                    <option>India</option>
                                                    <option>Japan</option>
                                                    <option>UK</option>
                                                    <option>France</option>
                                                    <option>Korea</option>
                                                    <option>China</option>
                                                  </select>
                                              </div>
                                        
                                              <div class = "form-group">
                                                  <label for="Gender_"><strong>Gender</strong></label> 
                                                  <select class="form-control input-md" name="Gender_" >
                                                    <option disabled="disabled">Select a Gender</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Others</option>
                                                  </select>
                                              </div>                                      
                                             </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                                      
                          <!--  -->
                          <?php endif?>
                          <?php endif?>
                          <?php if ($currentUser['id']!=$profile['id']) :?>
                        <?php else:?>
                        <?php if($userinfo['id']):?>
                          <!-- Button trigger modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Sửa
                              </button>

                              <!-- Modal -->
                              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Thông tin cá nhân</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <div aria-hidden="true">&times;</div>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                    <form method = "POST" enctype="multipart/form-data"action="updateinfo.php"  >
                                      <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-6"style="left:auto;right:auto" >
                                      <div class = "form-group">
                                            <label for="displayName"  ><strong>Fullname</strong></label>
                                            <input type="text" class = "form-control" id = "displayName" name = "displayName" value="<?php echo $currentUser['displayName'];?>" >
                                      </div>

                                      <div class = "form-group">
                                          <label for="describe"  ><strong>Describe </strong></label> 
                                          <input type="text" class = "form-control" id = "describe" name = "describe" value="<?php echo $userinfo['user_describe'];?>" >
                                      </div>

                                      <div class = "form-group">
                                          <label for="Relationship_status"  ><strong>Relationship status</strong></label> 
                                          <input type="text" class = "form-control" id = "Relationship_status" name = "Relationship_status" value="<?php echo $userinfo['Relationship_Status'];?>" >
                                      </div>
                                      <div class = "form-group">
                                          <label for="Lives"><strong>Lives In</strong></label> 
                                          <select class="form-control" name="Lives" >
                                            <option disabled>Select a Country</option>
                                            <option>Vietnam</option>
                                            <option>United States of America</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>UK</option>
                                            <option>France</option>
                                            <option>Korea</option>
                                            <option>China</option>
                                          </select>
                                      </div>
                                      </div>
                                            <div class="col-md-6"style="left:auto;right:auto">
                                      <div class = "form-group">
                                          <label for="numberPhone"  ><strong>numberPhone</strong></label> 
                                          <input type="text" class = "form-control" id = "numberPhone" name = "numberPhone" value="<?php echo $currentUser['numberPhone'];?>" >
                                      </div>
                                      <div class = "form-group">
                                          <label for="Gender_"><strong>Gender</strong></label> 
                                          <select class="form-control input-md" name="Gender_">
                                            <option disabled="disabled">Select a Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Others</option>
                                          </select>
                                      </div>
                                      <div class="form-group>">
                                            <label for="birthday"><strong>Ngày sinh</strong></label> 
                                          <input type="date" name="birthday"id = "birthday" class="form-control input-md"value="<?php echo $currentUser['birthday'];?>"> <br>
                                      </div>
                            
                                      <p><button name="save_info" class = "btn btn-primary">Save changes</button> </p>
                                      </div>
                                    </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                      </div>
                      <?php endif?>
                      <?php endif?>
              <?php
              echo"
                  <center><h2><strong>About</strong></h2></center><br>
                  <center><h4><strong>$userprofile</strong></h4></center>
                  <p><strong><i style='color:grey;'>______________________________________________</i></strong></p><br>
                  <p><strong><i style='color:grey;'><center>$des</center></i></strong></p><br>
                  <p><strong>Relationship Status: </strong> $status</p><br>
                  <p><strong>Lives In: </strong> $Live</p><br>
                  <p><strong>NumberPhone: </strong> $numberPhone</p><br>
                  <p><strong>Gender: </strong>$Gender  </p><br>
                  <p><strong>Date Of Birth: </strong>$dateformat  </p><br>
                  ";
                  ?>
                   </div>
                  </div>
                  <br>
                  <div class="card"style="height :420px" >
                  <div class="card-body">
                  <h4 style = "font-family:inherit;color:black"><strong>
                  <a href="friends.php?id=<?php echo $profile['id'] ?>">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a>
                  </strong></h4>
                  <div class="target" style="height:330px;overflow:scroll;" >
                  <div class="all_users1">
                  <div class="usersWrapper1">
                

                        <?php
                        $check=null;
                        if($get_frnd_num > 0){
                            foreach($get_all_friends as $row){
                               $check=$row->picture;
                           
                                echo  $check!=null ? '<div class="user_box1">
                                        <div class="user_img1"><a href="profile.php?id='.$row->id.'"</a> <img src="data:image/jpeg;base64,'.base64_encode($row->picture).'" alt="Profile image"></div>
                                        <a href="profile.php?id='.$row->id.'"<div class="user_info1"><span>'.$row->displayName.'</span></div> </a>' : '<div class="user_box1">
                                        <div class="user_img1"><a href="profile.php?id='.$row->id.'"</a> <img src="avatars/no-avatar.jpg" "></div>
                                        <a href="profile.php?id='.$row->id.'"<div class="user_info1"><span>'.$row->displayName.'</span></div> </a>' ;
                            }
                        }
                        else{
                            echo '<h4>You have no friends!</h4>';
                        }
                        ?>
                        
                              </div>
                              </div>
                              </div>
                         
                  </div>
                        </div>
            </div>
            <div class=" col-sm-8">
            <div class="card"style="left:auto;right:auto;top:auto;bottom:auto;width:auto;" >
            <div class="card-body">
                  <form action="profile.php?id=<?php echo $currentUser['id']?>" method="POST"enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="content"><strong>Nội dung</strong></label>
                          <textarea class="form-control" name="content" id="content" rows="3"placeholder="Bạn đang nghĩ gì?"required></textarea>		
                      </div>
                      <select id="select_priot1" class="fas btn btn-white" name="priority1"style="position: absolute; left:90px;top:156px;background-color: #FFFFFF">
                                <option class="fas" value="public"title="Mọi người">&#xf57d; Mọi người</option>
                                <option class="fas"value="friend"title="Bạn bè">&#xf500; Bạn bè</option> 
                                <option class="fas"value="onlyme"title="Chỉ mình tôi">&#xf023; Chỉ mình tôi</option>
                            </select>    
                      <img src="icon/camera.png" style="width:30px;height:30px;position: absolute; left:250px;top:160px" onclick="triggerClick1()"> 
                      <input type="file" class="form-control-file" id="picture_post_icon1"name="picture_post_icon1" style="display: none;">
                      <button type="submit" name="upstatus_profile" class="btn btn-primary">Đăng</button>
                  </form>
            </div>
        </div>
        	<br>
            <div class="card"style="left:auto;right:auto;top:auto;bottom:auto;width:auto;">
            <div class="card-body">
            <div class="target" style="height:832px;overflow:scroll;" ><center><strong>
            </strong></center> <span></span><br />
                <?php foreach ($postsprofile as $posts):?>
                  <div class="col-sm-12">
                
                      <div class="card" >
                          <div class="card-body"style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <h5 class="card-title">
                              <?php if($posts['picture']):?> 
                              <img style="width: 100px" class="card-img-top border border-info" src="avatar.php?id=<?php echo $posts['userId']?>"> 
                              <?php else: ?>
                              <img src="avatars/no-avatar.jpg" style="width: 100px" class="card-img-top border border-info">
                              <?php endif ?>
                              <?php echo $posts['Fullname'];?>
                              </h5>
                              <p class="card-text"> Đăng lúc: 
                              <?php echo $posts['createAt'];?>
                              </p>
                              <p class="card-text">
                              <?php echo $posts['content'];?>
                              </p>
                              <p class="card-text"><center>
                              <?php if($posts['picture_post']):?> 
                              <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $posts['picture_post']).'"/class="rounded mx-auto d-block" style="width:100%;height:100% ">'?>
                              <?php else: ?>
                              <!-- <img src="icon/no-image.png" style="width:45%;height:40% " class="card-img-top"> -->
                              <?php endif ?> 
                              </center>
                              </p>
                      
                             
                              <form  method="POST">
                              <div class="col"style="text-align: right;position: absolute; left:8px;top:8px ">
                                  <?php if($posts['Fullname'] == $currentUser['displayName']):?>
                         
                                  <select class="fas btn" id="priority3"name="priority3"  style="background-color: #FFFFFF">
                            
                                <?php if($posts['priority']=='public'):  ?>

                                <option class="fas" value="public"title="Mọi người">&#xf57d; Mọi người</option>
                                <option class="fas" value="friend"title="Bạn bè">&#xf500; Bạn bè</option> 
                                <option class="fas"value="onlyme"title="Chỉ mình tôi">&#xf023; Chỉ mình tôi</option>
                                <?php endif; ?>
                                <?php if($posts['priority']=='friend'):  ?>
                                <option class="fas"value="friend"title="Bạn bè">&#xf500; Bạn bè</option> 
                                <option class="fas"value="public"title="Mọi người">&#xf57d; Mọi người</option>
                                <option class="fas"value="onlyme"title="Chỉ mình tôi">&#xf023; Chỉ mình tôi</option>
                                <?php endif; ?>
                                <?php if($posts['priority']=='onlyme'):  ?>
                                    
                                <option class="fas"value="onlyme"title="Chỉ mình tôi">&#xf023; Chỉ mình tôi</option>
                                <option class="fas"value="public"title="Mọi người">&#xf57d; Mọi người</option>
                                <option class="fas"value="friend"title="Bạn bè">&#xf500; Bạn bè</option> 
                                <?php endif; ?>
                                    
                             
                            </select>
                      
                             <button  type="submit" id="priority3_btn"name="priority3_btn" value = <?php echo $posts['id'] ?>  class="fas btn btn-outline-dark " >&#xf102;</button> 
                        
                            <?php 
                                        if(isset($_POST['priority3_btn']))
                                        {
                                            $valuebtn=$_POST['priority3_btn'];
                                            $value = $_POST['priority3'];
                                            updateProrisifity($valuebtn,$value);
                                
                                            header("Location: profile.php?id=$userId");
                                            }
                                        ?>
                        
                            
                               <button type="submit" name="delete_post_profile" value = <?php echo $posts['id'] ?>  class="btn btn-danger" >Xóa</button>  
                                <?php 
                                  if(isset($_POST['delete_post_profile']))
                                  {
                                    $value = $_POST['delete_post_profile'];
                                    
                                    if (userLiked($posts['id'],$currentUser{'id'})){
                                      deletelike($posts['id']);
                                      deleteallcomment($posts['id']);
                                      var_dump($value);
                                      deletepost($value);
                                      header("Location: profile.php?id=$userId");;
                                      }else{
                                      deleteallcomment($posts['id']);
                                      deletepost($value);
                                      var_dump($value);
                                      header("Location: profile.php?id=$userId");
                                    }
                                      }
                              
                                  ?>
                            <?php else:?>
                            <?php endif;?>
                            </form>
                            </div>
                            <form  method="POST">
                            <div class="row">
                            <?php $countlike=getLikes($posts['id']);
                             $countcommemnt=getcountcomments($posts['id'])
                            ;?>
                                        <div class="btn-group"style="position: relative;bottom:6px;left:23px">
                                                <?php if (userLiked($posts['id'],$currentUser{'id'})): ?>
                                                <a class="btn"name="unlike"id="unlike"href="like1.php?type=unlike&id=<?php echo $posts['id'] ?>"><i style='font-size:20px' class='far fa-thumbs-up'data-toggle="tooltip" title="Cảm xúc của bạn với status này!!"></i> Thích<span class="badge badge-primary  rounded-circle" ><?php echo implode(" ",$countlike);?></span></a>
                                                <?php else:?>
                                                <a class="btn"name="like"id="like"href="like1.php?type=like&id=<?php echo $posts['id'] ?>"style='color:black'><i style='font-size:20px' class='far fa-thumbs-up'data-toggle="tooltip" title="Cảm xúc của bạn với status này!!"></i> Thích<span class="badge badge-light  rounded-circle"><?php echo implode(" ",$countlike);?></span></a>
                                                <?php endif ?>
                                        </div>&emsp;&emsp;
                                        <div >
                                
                                            <h9 aria-haspopup="true" aria-expanded="false"><i style='font-size:20px' class='far fa-comment-alt'data-toggle="tooltip" title="Cảm nghĩ của bạn về bài viết này!"></i> Bình luận<span class="badge badge-light  rounded-circle"><?php echo implode(" ",$countcommemnt);?></span></h9>
                                           
                                        </div>&emsp;&emsp;
                                  
                                            <div>
                                                <h9 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i style='font-size:20px' class='fa fa-share'data-toggle="tooltip" title="Chia sẻ với bạn bè"></i> Chia sẻ </h9>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Chia sẻ ngay (Công khai)</a>
                                                    <a class="dropdown-item" href="#">Chia sẻ trên dòng thời gian với bạn bè</a>
                                                    <a class="dropdown-item" href="#">Chia sẻ lên trang</a>
                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                    <?php $getcomment=getcomment($posts['id']);
                                   
                                   ?>
                                    <?php if(usercommentd($posts['id'],$currentUser['id'])): ?>
                                    <div class="target" style="height:200px;overflow:scroll;" >
                                            <?php foreach ($getcomment as $postss):?>
                                                
                                          <div class="card" >
                                          <div class="card-body">
                                                        <h5 class="card-title">
                                                            <?php if($postss['picture']):?> 
                                                            <img style="width: 50px;height: 50px" class="card-img-top border border-primary" src="avatar.php?id=<?php echo $postss['userId']?>">  
                                                            <?php else: ?>
                                                            <img src="avatars/no-avatar.jpg" style="width: 50px;height: 50px" class="card-img-top border border-primary">
                                                            <?php endif ?> 
                                                            <a href="profile.php?id=<?php echo $postss['userId'] ?>"><div style="position: absolute; left:80px;top:20px " ><?php echo $postss['Fullname']?> </div> </a>
                                                        </h5> 
                                
                                                        <p class="card-text"style="position: absolute; left:80px;top:50px" > Bình luận lúc: 
                                                            <?php echo $postss['createdAt'];?>
                                                        </p>
                                                        <p >
                                                            <?php echo $postss['content'];?>
                                                        </p>
                                                    <div class="col"style="text-align: right;position: absolute; left:8px;top:8px ">
                                                    <form  method="POST">
                                                        <button  type="submit" name="deletecomment" value = <?php echo $postss['id_'] ?>  class="btn btn-danger" >Xóa</button>   
                                                                  
                                                                        <?php 
                                                                        if(isset($_POST['deletecomment']))
                                                                        {
                                                                            $value_commnet=$_POST['deletecomment'];
                                                                          
                                                                            deletecomment($value_commnet);
                                                                            header("Location: profile.php?id=$userId");
                                                                            }
                                                                        ?>

                                                    </form>
                                                        </div>  
                                                        </div>  
                                                </div>
                                            <?php endforeach ?>
                                                            </div>
                                    <?php else:?>
                                            <div></div>
                                    <?php endif?>
                                  
                                
                                    <form action="upcomment.php?type=upcommentprofile&id=<?php echo $posts['id'] ?>" method="POST" >
                                        <div class="form-group">
                                            <textarea style="height:50px" class="form-control" name="contentss" id="contentss" rows="3"placeholder="Thêm bình luận..."></textarea>                                
                                        </div>        
                                        <button type="submit" class="btn btn-primary" name="upcomment">comment</button>
                                    </form>	
                  
                              </div>
                              </div>
                              
                      <br>
                   
                  </div>
                  <?php endforeach ?>
                  </div>
            </div>
          </div> 
    </div>
  </div>
</div>
      </div>
      </div>
</div>
<?php endif; ?>
<br>
<?php include 'footer.php';?>