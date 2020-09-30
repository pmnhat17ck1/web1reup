
<?php
require_once 'init.php';
if(!$currentUser){
  header('Location: index.php');
 exit();
}
if (isset($_POST['content'])) {
  sendMessage($currentUser['id'], $_GET['id'], $_POST['content']); 
}

$messages = getMessagesWithUserId($currentUser['id'], $_GET['id']);
$user = findUserById($_GET['id']);
if(isset($_POST['Message']))
{
  deleteMessageWithId($_POST['Message']);
  header('Location: conversation.php?id=' . $_GET['id']);
}
?>
<?php include 'header.php' ?>
<div class="container">
<br><br><br><br>
<center><h1 style="font-family: inherit;">Cuộc trò chuyện với: <?php echo $user['displayName'] ?></h1></center>
  <br>
    <form action = ""  method="POST">
    <div class="card">
    <div class="card-body">

      <?php foreach ($messages as $message) : ?>
      
        <div class="form-group"style="margin-top:0px;margin-bottom:0px;">
          <?php if ($message['type'] == 1) : ?>   
            <div class="badge badge-pill alert alert-warning"style="padding-right:10px;">
                <img style="width:30px;height:30px;"class="rounded-circle" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($user['picture']); ?>">&ensp;
                <strong><?php echo $user['displayName'] ?></strong>:
                <?php echo $message['content'] ?>
                <button style="font-size:1px;" type="submit" id="Message" name="Message" class="btn btn-danger" value="<?php echo $message['id']; ?>"><i style="font-size:10px;"class='fas'> &#xf2ed;</i></button>
                <div style="position: relative;right:5px ;bottom:5px;font-size: 10px;"><?php echo $message['createdAt'] ?></div>
              </div>            
            <?php else: ?>
              <div class="card-text text-right">
                <div class="badge badge-pill alert alert-primary" style="padding-right:10px;">
                  <?php echo $message['content'] ?>&emsp;
                  <button style="font-size:1px;" type="submit" id="Message" name="Message" class="btn btn-danger" value="<?php echo $message['id']; ?>"><i style="font-size:10px;"class='fas'> &#xf2ed;</i></button>
                  <div style="position: relative; bottom:-1px;right:20px;font-size: 7px;"><?php echo $message['createdAt'] ?></div>
                </div>
              </div>
               
            <?php endif; ?>
          
      <?php endforeach; ?>
      
      </div>
    </form>
    <br><br>
    <form method="POST">
      <div class="card-text text-center">
        <div class="form-group">      
          <img style="width:40px;height:40px;"class="rounded" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($currentUser['picture']); ?>">&ensp;
          <textarea style="width:40%;height:40px;border:1px solid grey;position: relative; top:15px"id="content" name="content"placeholder="Nhập tin nhắn..."></textarea>
   
           <button type="submit" class="btn btn-primary" >Gửi</button>
        
        </div>       
      </div>           
    </form>
    <br>
    </div>
    </div>
            </div>

<?php include 'footer.php' ?>