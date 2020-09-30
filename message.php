<?php
require_once 'init.php';
if(!$currentUser){
  header('Location: index.php');
 exit();
}
$conversations = getLatestConversations($currentUser['id']);
if(isset($_POST['deleteall']))
{
  deleteAllMessageId($currentUser['id'], $_POST['deleteall']);
  header('Location: message.php');
}
?>
<?php include 'header.php' ?>
<div class="container">
    <br>   <br>   <br>   <br>

    <center><h1><strong style="font-family: inherit;">Messenger</strong></h1></center>
    <br>
    <div class="card">
    <div class="card-header"style="font-family:inherit;">
      <strong>Gần đây</strong>&ensp;
      <a href="new-message.php"role="button" aria-pressed="true" style="margin-left:70%;"><i class='fas'>&#xf7f5;</i> Cuộc trò chuyện mới</a>
    </div>
    <div class="card-body">
      <?php foreach ($conversations as $conversation) : ?>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">
          <div class="row">
              
            <div class="col">
              <?php if ($conversation['picture']) : ?>
                <img style="width:50px;" class="img-thumbnail" src="<?php echo 'data:image/jpeg;base64,' . base64_encode($conversation['picture']); ?>">
                <a style="font-family:Courier New;" href="conversation.php?id=<?php echo $conversation['id'] ?>"><strong><?php echo $conversation['displayName'] ?></strong></a>
               
              <?php else : ?>
              <img class="avatar" src="no-avatar.jpg">
              <?php endif; ?>
            </div>
            <form method="POST">
                <p   ><button type="submit" class="btn btn-danger" name="deleteall" value="<?php echo $conversation['id']; ?>"><i class='fas'>&#xf2ed;</i></button></p>
              </form>
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
    <div class="card-footer">
    </div>
  </div>  

</div>

<?php include 'footer.php' ?>