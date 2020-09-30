<?php
ob_start();
 require_once 'init.php';
?>
<?php include 'header.php'; ?>
<br><br><br><br>
<?php if (isset($_POST['search-friend'])): ?>
<?php
    $name = $_POST['search-friend'];
    $peoples = searchFriendByName($name);
?>
    <?php if(empty($peoples)):?>
    <div style="text-align: center;">
        <h4>Không có kết quả tìm kiếm cho '<?php echo $name;?>'</h4>
    </div>
    <?php else: ?>
    <div style="text-align: center;">
        <h4>Kết quả tìm kiếm cho '<?php echo $name;?>'</h4>    
    </div>
  <div class="card" style="width: 80%; margin: 0 auto; border: none;"><h4>Mọi người</h4></div>
  <br>  
  <div class="card"style="width: 80%; margin: 0 auto; border: none;">
  <div class="card-body">
  <?php foreach ($peoples as $people ) : ?>
    <a href ="profile.php?id=<?php echo $people['id'];?>" >
    <ul class="list-unstyled">
        <li class="media">
                <?php if($people['picture']):?> 
                    <img style="width: 100px;height: 110px" class="card-img-top" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($people['picture']); ?>"><br>      
                    <?php else: ?>
                      <img src="avatars/no-avatar.jpg" style="width: 100px;height: 110px" class="card-img-top"><br>  
                      <?php endif ?> 
          <div class="media-body">
            <h5 class="mt-0 mb-1"><strong style = "font-family:inherit;font-size:12"><?php echo $people['displayName'];?></strong></h5>
            <a href ="friends.php?id=<?php echo $people['id'];?>" >Xem danh sách Friend</a>
          </div>
        </li>
        </ul>
                    </a>
  <?php endforeach; ?>
  </div>
  </div>
<?php endif;?>
<?php endif;?>
<?php header('Cache-Control: no cache'); //no cache
?>
<?php include 'footer.php'; ?>