<?php
require_once 'init.php';
if(!$currentUser){
  header('Location: index.php');
 exit();
}
if (isset($_POST['userId']) && isset($_POST['content'])) {
  sendMessage($currentUser['id'], $_POST['userId'], $_POST['content']);
  
  header('Location: conversation.php?id=' . $_POST['userId']);
}
$getusers = getUsers();

?>
 
<?php include 'header.php' ?>
<div class="container">
<br><br><br><br>
<center><h1 style="font-family: inherit;">Tin nhắn mới</h1></center>
  <br>
  <div class="card">
    <div class="card-body">
  <form method="POST">
  <div class="form-group"style="margin-left:-7px;">
    <label for="userId">Tới</label>
    <select class="form-control" id="userId" name="userId"style="width:100%">
      <?php foreach($getusers as $getusers) : ?>
      <option value="<?php echo $getusers['id'] ?>"><?php echo $getusers['displayName'] ?></option>
      <?php endforeach; ?>
    </select> 
  </div>
  <div class="form-group"style="margin-left:-7px;">
    <label for="content">Tin nhắn</label>
      <textarea style="width:100%" class="form-control" id="content" name="content" rows="1" placeholder="Nhập tin nhắn"></textarea>
  </div>  
  <div class="form-group"align="right" >  
  <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
  </div>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      if(isset($_POST['content']))
      {
        $td = 'Bạn nhận được tin nhắn từ '.$currentUser['displayName'].' ';
        $nd = $currentUser['displayName'].' đã gửi cho bạn tin nhắn. Nội dung tin nhắn: '.$_POST['content'].'';
        sendEmail($getusers['email'], $getusers['displayName'], $td, $nd);
      }
    }
  
      ?>
      </div>
      </div>
</div>
<?php include 'footer.php' ?>