<?php
ob_start();
 require_once 'init.php';
 $page=isset($_GET['page']) ? (int)$_GET['page'] : 1;
 $perPage=isset($_GET['per-page']) && $_GET['per-page']<=50 ? (int)$_GET['per-page'] : 10;
//positioning
$start = ($page >1) ? ($page * $perPage)-$perPage :0;
//checkfriend
//query
global $db;
$phantrang= $db->prepare("SELECT SQL_CALC_FOUND_ROWS p.id,p.userId,u.picture,u.displayName as Fullname,p.content,p.createAt,p.priority ,p.picture_post
FROM users AS u JOIN posts as p  WHERE u.id= p.userId   ORDER BY p.createAt DESC LIMIT {$start},{$perPage}
");
$phantrang->execute();
$phantrang=$phantrang->fetchAll(PDO::FETCH_ASSOC);
//page
 $total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$pages=ceil($total/$perPage);
$user=$currentUser['id'];
$get_frnd_nums = get_all_friends($user, false);
?>
<?php include 'header.php'; ?>
<style>
#myDIV {
  width: 100%;
  padding: 50px ;
  border: 1px solid rgba(23,23,23, .1);
  background-color: #E9EBEE;
}
#myDIV1 {
  width: 100%;
  height: auto;
  padding: 10px ;
  border: 2px solid rgba(23,23,23, .1);
  background-color: #FFFFFF;
 
}
</style>
<br>
<?php if ($currentUser): ?>
<div class="container">

    <p>Chào mừng "<?php echo $currentUser['displayName'];?>" đã quay trở lại</p>
    <div class="card" >
            <div class="card-body">
            <form action="upstatus.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="content"><strong>Nội dung</strong></label>
                    <textarea class="form-control" name="content" id="content" rows="3"placeholder="Bạn đang nghĩ gì?"required></textarea>
                    <div>
                            <select id="select_prioty" class="fas btn btn-white" name="priority">
                                <option class="fas"value="public"title="Mọi người">&#xf57d; Mọi người</option>
                                <option class="fas"value="friend"title="Bạn bè">&#xf500; Bạn bè</option> 
                                <option class="fas"value="onlyme"title="Chỉ mình tôi">&#xf023; Chỉ mình tôi</option>
                            </select>     
                            <img src="icon/camera.png" style="width:30px;height:30px;" onclick="triggerClick()">               
                        </div>        
                </div>
               
                
                <input type="file" class="form-control-file" id="picture_post_icon"name="picture_post_icon" style="display: none;">
                <button type="submit" class="btn btn-primary" name="index_post">Đăng</button>
            </form>	
            </div>
    </div>
    <br>

<div class="row">
    <?php foreach ($phantrang  as $posts):?>      
        <?php if((($posts['priority']=='public')||($posts['priority']=='friend' && $get_frnd_nums!=null))||(($posts['priority']=='onlyme')&&($posts['Fullname']==$currentUser['displayName']))):  ?>

        <div class="col-sm-12">
            <form  method="POST">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php if($posts['picture']):?> 
                            <img style="width: 100px;height: 120px" class="card-img-top border border-primary" src="avatar.php?id=<?php echo $posts['userId']?>">  
                            <?php else: ?>
                            <img src="avatars/no-avatar.jpg" style="width: 100px;height: 110px" class="card-img-top border border-primary">
                            <?php endif ?> 
                            <a href="profile.php?id=<?php echo $posts['userId'] ?>"><div style="position: absolute; left:126px;top:55px "><?php echo $posts['Fullname']?> </div> </a>
                        
                        </h5>
                        <p class="card-body">
                            <?php echo $posts['content'];?>
                        </p>
                        <p class="card-text"><center>
                        <?php if($posts['picture_post']):?> 
                        <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $posts['picture_post']).'"/class="rounded mx-auto d-block" style="width:100%;height:100% ">'?>
                        <?php else: ?>
                        
                        <?php endif ?> 
                        </center>
                        </p>
                        <p>
                            <?php 
                                $NamePriority =  getNameProrisifity($posts['priority']);

                            ?>
                        </p>
                    
                    

                        <p class="card-text"style="position: absolute; left:126px;top:100px "> Đăng lúc: 
                            <?php echo $posts['createAt'];?>
                        </p>
       
                        <?php $countlike=getLikes($posts['id']);
                             $countcommemnt=getcountcomments($posts['id'])
                        ?>
           
                  

                        <div class="col"style="text-align: right;position: absolute; left:8px;top:8px ">
                        <?php if($posts['userId'] == $currentUser['id']):?>
                         
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
                                
                                            header("Location: index.php");
                                            }
                                        ?>
                               
                            
                                <button type="submit" name="delete" value = <?php echo $posts['id'] ?>  class="btn btn-danger" >Xóa</button>   
                                <?php 
                                if(isset($_POST['delete']))
                                {
                                    $value = $_POST['delete'];
                                    
                                    if (userLikedd($posts['id'])){
                                        deletelike($posts['id']);
                                        deleteallcomment($posts['id']);
                                      
                                        deletepost($value);
                                       header("Location: index.php");
                                    }else{
                                    deleteallcomment($posts['id']);
                                    deletepost($value);
                                    header("Location: index.php");
                                }
                                    }
                                ?>
                            <?php else:?>
                                <select class="fas btn" id="priority3"name="priority3"  style="background-color: #FFFFFF">
                                <?php if($posts['priority']=='public'):  ?>

                                <option class="fas" value="public"title="Mọi người">&#xf57d; Mọi người</option>
                               
                                <?php endif; ?>
                                <?php if($posts['priority']=='friend'):  ?>
                                <option class="fas"value="friend"title="Bạn bè">&#xf500; Bạn bè</option> 
                             
                                <?php endif; ?>
                                <?php if($posts['priority']=='onlyme'):  ?>
                                    
                                <option class="fas"value="onlyme"title="Chỉ mình tôi">&#xf023; Chỉ mình tôi</option>
                               
                                <?php endif; ?>
                                 </select>
                            <?php endif;?>
                            </div>
                                <div class="card-body">
                                <hr>
                                    <div class="row">
                                       
                                        <div class="btn-group"style="position: relative;bottom:6px;left:23px">
                                                <?php if (userLiked($posts['id'],$currentUser['id'])): ?>
                                                <a class="btn"name="unlike"id="unlike"href="like.php?type=unlike&id=<?php echo $posts['id'] ?>"><i style='font-size:20px' class='far fa-thumbs-up'data-toggle="tooltip" title="Cảm xúc của bạn với status này!!"></i> Thích  <span class="badge badge-primary  rounded-circle" ><?php echo implode(" ",$countlike);?></span></a>
                                                <?php else:?>
                                                <a class="btn"name="like"id="like"href="like.php?type=like&id=<?php echo $posts['id'] ?>"style='color:black'><i style='font-size:20px' class='far fa-thumbs-up'data-toggle="tooltip" title="Cảm xúc của bạn với status này!!"></i> Thích  <span class="badge badge-light  rounded-circle"><?php echo implode(" ",$countlike);?></span></a>
                                                <?php endif ?>
                                        </div>&emsp;&emsp;
                                        <div >
                                        <form method="post">
                                            <h9 aria-haspopup="true" aria-expanded="false"><i style='font-size:20px' class='far fa-comment-alt'data-toggle="tooltip" title="Cảm nghĩ của bạn về bài viết này!"></i> Bình luận<span class="badge badge-light  rounded-circle"><?php echo implode(" ",$countcommemnt);?></span></h9>
                                            </form>

                                 
                                        </div>&emsp;&emsp;
                                       
                                            
                                                    <div>
                                                        <h9 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i style='font-size:20px' class='fa fa-share'data-toggle="tooltip" title="Chia sẻ với bạn bè"></i> Chia sẻ </h9>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Chia sẻ ngay (Công khai)</a>
                                                            <a class="dropdown-item" href="#">Chia sẻ trên dòng thời gian với bạn bè</a>
                                                            <a class="dropdown-item" href="#">Chia sẻ lên trang</a>
                                                        </div>
                                                    </div>
                                        <hr>
                                        </div>
                                    
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
                                          
                                                        <button  type="submit" name="deletecomment" value = <?php echo $postss['id_'] ?>  class="btn btn-danger" >Xóa</button>   
                                                                  
                                                                        <?php 
                                                                        if(isset($_POST['deletecomment']))
                                                                        {
                                                                            $value_commnet=$_POST['deletecomment'];
                                                                           
                                                                            deletecomment($value_commnet);
                                                                           header("Location: index.php");
                                                                            }
                                                                        ?>
                                                      
                                                        </div>  
                                                        </div>  
                                                </div>
                                            <?php endforeach ?>
                                                            </div>
                                        <?php else:?>
                                                <div></div>
                                        <?php endif?>
                                      
                                    
                                        <form action="upcomment.php?type=upcommentindex&id=<?php echo $posts['id'] ?>" method="POST" >
                                            <div class="form-group">
                                                <textarea style="height:50px" class="form-control" name="contents" id="contents" rows="3"placeholder="Thêm bình luận..."></textarea>                                
                                            </div>        
                                            <button type="submit" class="btn btn-primary" name="upcomment">comment</button>
                                        </form>	
                                     
                            
                            </div>        
                    </div>
                </div><br>
            </form>
        </div>
        <?php endif; ?>
    <?php endforeach ?>
    
                    <!-- <script>
                    $('#totalicon ').on('click','a', function(){
                        $icon=($(this).attr('id'));
                        
                        alert($icon)
                        
                        //insertlike($currentUser['id'],66,$icon);
                    });
                    </script> -->
                  
    <div class="container-fluid">
        <div class="row justify-content-center">
            <ul class="pagination"   >
                <?php if($page<=1):?>
                        <li class="page-item disabled">
                    <a class="page-link" href="?page=<?php echo ($page-1)  ;?>" tabindex="-1">Previous</a>
                    </li>
                <?php else:?>
                    <li class="page-item ">
                        <a class="page-link" href="?page=<?php echo ($page-1)  ;?>" tabindex="-1">Previous</a>
                        </li>
                <?php endif ?>
                
                <?php for($x=1;$x<=$pages;$x=$x+1): ?>
                    <?php if($page==$x): ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link"  href="?page=<?php echo $x;?>"><?php echo $x; ?></a>
                        </li>
                    <?php else: ?>
                        <li class="page-item ">
                            <a class="page-link"  href="?page=<?php echo $x;?>"><?php echo $x; ?></a>
                        </li>
                    <?php endif ?>
                <?php endfor;?>
                <?php if($page>=$pages):?>
                <li class="page-item "><a class="page-link" href="?page=<?php echo $page=1;?>">Next</a>
                </li>
                <?php else:?>
                    <li class="page-item "><a class="page-link" href="?page=<?php echo $page+1;?>">Next</a>
                </li>
                <?php endif ?>
            </ul>
            </div>
            </div>
</div>
<?php else:?>
    <div class="container">
        <div class="row">
            <div class="col-sm-8" >
                <h2> <strong>See what's happening <br> in the world right now</strong></h2><br>
            <div class="social">
                <img style="width: 380px;" src="https://cdn.pixabay.com/photo/2017/02/25/23/52/connections-2099068_1280.png">
            </div >
        </div>
            <div class="col-sm-4">
                <div class="register_index">
                <h1 style="font-family: inherit;font-size:36px ">Đăng ký</h1>
                <h3 style="font-family: inherit;font-size: 19px">Nhanh chóng dễ dàng</h3>
                <div class="card"style="width:350px">
                    <div class="card-body">
                    <form action="register.php" method = "POST">
                        <div class = "form-group">
                            <label for="displayName"  ><strong>Họ tên</strong></label>
                            <input type="text" class = "form-control" id = "displayName" name = "displayName" placeholder = "Họ tên"required >
                        </div>
                        <div class = "form-group">
                            <label for="email"  ><strong>Email</strong></label> 
                            <input type="email" class = "form-control" id = "email" name = "email" placeholder = "Email" required>
                        </div>
                        <div class = "form-group">
                            <label for="password"><strong>Mật Khẩu</strong></label> 
                            <input type="password" class = "form-control" id = "password" name = "password" placeholder = "Mật Khẩu"required>
                        </div>
                        <div class = "form-group">
                            <label for="numberPhone"><strong>Số điện thoại</strong></label> 
                            <input type="tel" pattern="^\+?(?:[0-9]??).{5,14}[0-9]$" class = "form-control" id = "numberPhone" name = "numberPhone" placeholder="+8400000000" required>
                        </div>
                        <div class="form-group>">
                            <label for="birthday"><strong>Ngày sinh</strong></label> 
                            <input type="date" name="birthday"id = "birthday" class="form-control input-md" required>
                        </div><br>
                        <a style="text-decoration:none;float: right; color:#187FAB;" data-toggle="tooltip" title="login" href="login.php">Already have an account?</a>
                        <p><button type = "submit" class = "btn btn-primary">Đăng Ký</button> </p>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif?>
<?php include 'footer.php'; ?>

