<!doctype html>
<html lang="en">
  <head >
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src="scripts/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="scripts/scripts.js"></script>
    <link rel="stylesheet" href="style/style.css" media="all"/>
  </head>
<body style="background-color: #E9EBEE ">
  <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark ; position: fixed;"style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
    <a class="navbar-brand " href="index.php"><strong>Bamboo social</strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto ">
      <?php if (isset($currentUser)):?>
        <form action = "search.php" class="form-inline my-2 my-lg-0" method="post">
          <input type="search" class="form-control mr-sm-2"style= "width:350px;height:auto" type="text" name="search-friend" id="search-friend" placeholder="Search..." aria-label="Search"Required>
          <button class="btn btn-outline-success my-2 my-sm-0 " type="submit"name="search-btn">Search</button>
        </form>
        
      <?php endif;?>
    </ul>
      <?php if (!$currentUser):?>
      <div class="navbar-nav mr-end">
          <form action="login.php" method="POST">
            <table>
              <tr>
                <th style="color: #e3f2fd" >Username</th>
               
                <th style="color: #e3f2fd" >Password</th>
              </tr>
              <tr>
                <td><input type="email" class="form-control" id="email" name="email" placeholder="Tên đăng nhập"required ></td>
                <td  ><input type="password" class="form-control" id="password" name="password" placeholder="mật khẩu" required> </td>
                <td><button type="submit" class="btn btn-primary"min=-100 max=100 >Đăng nhập</button></td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                <div style="text-align: right" >
                  <a href ="forgetpass.php">Quên mật khẩu?</a>
                </div>
               </td>
              </tr>
      </table>
          </form>	
      </div>
  </div>
  </nav>
      <?php else:?>
        
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?php echo $page =='profile' ? 'active':''?>">
        <a class="nav-link" href="profile.php?id=<?php echo $currentUser['id']?>">
          <?php if($currentUser['picture']):?> 
            <img style="width: 30px;height: 30px" class="card-img-top border border-success" src="avatar.php?id=<?php echo $currentUser['id']?>">
            <?php else: ?>
            <img src="avatars/no-avatar.jpg" style="width: 30px;height: 30px" class="card-img-top border border-success">
            <?php endif ?>
   
          <?php echo $currentUser ? ''. $currentUser['displayName'].'':''?>
        </a>
        </li>
        <li class="nav-item <?php echo $page =='index' ? 'active':''?>">
        <a class="nav-link" href="index.php">Trang chủ </a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php $getrow=getRowfriendRequest($currentUser['id']); ?>
                <?php if($getrow==null):?>
                  <i class='fas fa-user' style='font-size:auto;'></i>
                <?php else:?>
                  <i class='fas fa-user' style='font-size:auto;'><span class="badge badge-danger rounded-circle" style="position: absolute;right:-0cm;top:1px;width:15px;height:17px"><?php echo $getrow ?></span> </i>
                <?php endif?>
          </a>
          <div class="dropdown-menu" style= "left: -140px;width:auto;height:auto"aria-labelledby="navbarDropdown">
            <?php 
                 $friendship = getAllFriendRequest($currentUser['id']);
                 ?>
               
                    <p style="text-align: center"><strong> Lời mời kết bạn</strong></p>
                         <hr noshade="noshade">  
                       
                 <?php
                foreach ($friendship as $friend)
                {

                  $Namefriend = getNamefriend($friend['userId1']);
                  $getuser= findUserByID($friend['userId1']);
                  
            ?>
                  
               
                  <div class="card-body" >
                    <div class="row" >
                    <div class="col-sm-12">
                    <h5 class="card-title"style="width:300px;height:auto">
                        <?php if($getuser['picture']):?> 
                                <img style="width: 50px;height: 50px" class="card-img-top" src="avatar.php?id=<?php echo $friend['userId1']?>">  
                                <?php else: ?>
                                <img src="avatars/no-avatar.jpg" style="width: 50px;height: 50px" class="card-img-top">
                                <?php endif ?> 
                                <a href="profile.php?id=<?php echo $friend['userId1'] ?>"><?php echo $Namefriend['displayName']; ?></a>
                          </h5>
                      <div>
                            <form method="POST" action="add-removefriendindex.php">
                            <input type="hidden" name="id" value="<?php echo $friend['userId1'] ; ?>">
                              <button type="submit" class="btn btn-primary"name="btnclickAccpetindex" style="position: absolute; right:65px;top:50px"> Đồng ý </button> 
                              </form>
                    
                            <form method="POST" action="add-removefriendindex.php">
                            <input type="hidden" name="id" value="<?php echo $friend['userId1'] ; ?>">
                              <button type="submit" class="btn btn-primary"name="btnclickDelineindex" style="position: absolute; right:1px;top:50px">Hủy</button> 
                              </form>
                           </div>
                        </div>
                        </div> 
             </div>      
             <hr noshade="noshade">  
            <?php
            
                }
            ?>
      
    
          </div>
        </li>
      <li class="nav-item dropdown <?php echo $page =='messenger' ? 'active':''?>">

        <a class="nav-link dropdown"  id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php $conversations = getLatestConversations($currentUser['id']);
                            $row=getrowmes($currentUser['id']);?>
           <?php if($row==null):?>
                <i class='fas fa-comments' style='font-size:auto;text-align: center'></i>
                <?php else:?>         
                <i class='fas fa-comments' style='font-size:auto;text-align: center'><span class="badge badge-danger rounded-circle" style="position: absolute;right:-0cm;top:1px;width:15px;height:17px"><?php echo $row ?></span> </i>
                <?php endif?>
                <div class="dropdown-menu"style="left:-250px;right:auto;top:auto;bottom:auto;width:auto;height:350px" >
                  
                        <div class="modal-content"style="left:auto;right:auto;top:-25px;bottom:auto;width:350px;height:auto">
                          <div class="modal-header" style="width:auto;height:auto;">
                            <h6 class="modal-title"style="color:black;">Tin nhắn</h6><a href="new-message.php"role="button" aria-pressed="true"><i class='fas'>&#xf7f5;</i> Cuộc trò chuyện mới</a>
                          </div>
                          <div class="modal-body">
                            <p>
                        
                            <div class="target" style="height:300px;overflow:scroll;" >
                            <?php foreach ($conversations as $conversation) : ?>      
                                  <div class="card">
                                    <div class="card-body">
                                      <h4 class="card-title">
                                        <div class="row">
                                            
                                          <div class="col">
                                            <?php if ($conversation['picture']) : ?>
                                              <img style="width:50px;height:50px" class="img-thumbnail" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($conversation['picture']); ?>">
                                              <a style="font-family:Courier New;" href="conversation.php?id=<?php echo $conversation['id'] ?>"><strong style="font-size: 20px;"><?php echo $conversation['displayName'] ?></strong></a>
                                            
                                            <?php else : ?>
                                            <img class="avatar" src="no-avatar.jpg">
                                            <?php endif; ?>
                                          </div>
                                          <form method="POST">
                                              <p   ><button type="submit" class="btn btn-danger" name="deleteall" value="<?php echo $conversation['id']; ?>"><i class='fas'>&#xf2ed;</i></button></p>
                                            </form>
                                            <?php if(isset($_POST['deleteall']))
                                                    {
                                                      deleteAllMessageId($currentUser['id'], $_POST['deleteall']);
                                                       echo "<script>window.open('index.php','_self')</script>";
                                                    } ?>
                                        </div>
                                      </h4>
                                      <p class="card-text"style="margin-top:-35px;margin-left:55px">
                                        <small style="font-family:inherit;font-size:10px">Tin nhắn cuối vào lúc: <?php echo $conversation['lastMessage']['createdAt'] ?></small>
                                      </p>
                                      <p style="font-family:inherit;font-size:20px;margin-left:20px">Nội dung: <?php echo $conversation['lastMessage']['content'] ?></p>
                                    </div>
                                  </div>
                                 
                                  <?php endforeach; ?>
                                            </div>
                                 
                            </p>
                          </div>
                          <div class="modal-footer">
                             
                               <a type="button" href="message.php" class="btn btn-secondary">See all</a>
                          </div>
                        </div>
            
            
                </div>
            </a>
      </li>
      <li class="nav-item <?php echo $page =='notify' ? 'active':''?>">
        <a class="nav-link dropdown"  id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class='fas fa-bell' style='font-size:auto;text-align: center'></i>
          <div class="dropdown-menu"style="left:-100px;right:auto;top:auto;bottom:auto;width:350px;height:auto" >

                <center><strong>Thông báo</strong></center><hr>
                <?php $Notice= getNoticeWithUserId();
                
                
                ?>
                <div class="target" style="height:300px;overflow:scroll;" >
             
                <?php foreach ($Notice as $Notice) : ?>
                  <?php $friends = getfriend($currentUser['id'],$Notice['userId_notice']) ;
                  ?>
                  <?php if($Notice['userId_notice'] != $currentUser['id'] && $friends != null): ?>
                  <div class="card">
                  <div class="card-body">
                  <h5 class="card-title">
                  <?php echo $Notice['displayName'] ?>
                  <?php if($Notice['picture']):?> 
                  <img style="width:50px;height:50px" class="img-thumbnail" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($Notice['picture']); ?>">
                  <?php else: ?>
                  <img src="avatars/no-avatar.jpg" style="width: 50px;height: 50px" class="img-thumbnail">
                  <?php endif ?>   
                  <div style="position: relative;;bottom:5px;font-size: 10px;"><?php echo $Notice['createAt'] ?></div>
                </h5>
                  <p><?php echo $Notice['content'] ?></p>
                  </div>
                </div>
                <?php endif?>
            
                <?php endforeach; ?>  
              
                </div>
                <hr>                                  
          </div>
        </a>
      </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Cài đặt
          </a>
          <div class="dropdown-menu" style="width:300px;" aria-labelledby="navbarDropdown">
            <a class="dropdown-item <?php echo $page =='update-profile' ? 'active':''?>" href="update-profile.php">Thông tin cá nhân</a>
            <a class="dropdown-item <?php echo $page =='change_password' ? 'active':''?>" href="change_password.php">Đổi mật khẩu </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item <?php echo $page =='logout' ? 'active':''?>" href="logout.php">Đăng xuất<?php echo $currentUser ? ' ('. $currentUser['displayName'].')':''?></a>
          </div>
        </li>
      </ul>
      <?php endif;?>
  </div>
</nav>