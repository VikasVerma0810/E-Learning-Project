<?php

include '../components/dbconnect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['delete_comment'])){

   $delete_id = $_POST['comment_id'];

   $verify_comment = "SELECT * FROM `comments` WHERE id = '$delete_id'";
   $verify_comment_result = mysqli_query($conn, $verify_comment);

   if(mysqli_num_rows( $verify_comment_result) > 0){
      $delete_comment = "DELETE FROM `comments` WHERE id = '$delete_id'";
      $delete_comment_result = mysqli_query($conn, $delete_comment);
      $message[] = 'comment deleted successfully!';
   }else{
      $message[] = 'comment already deleted!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   

<section class="comments">

   <h1 class="heading">user comments</h1>

   
   <div class="show-comments">
      <?php
         $select_comments = "SELECT * FROM `comments` WHERE tutor_id = '$tutor_id'";
         $select_comments_result = mysqli_query($conn, $select_comments);
         if(mysqli_num_rows( $select_comments_result) > 0){
            while($fetch_comment = mysqli_fetch_assoc( $select_comments_result)){
               $comment_id = $fetch_comment['content_id'];
               $select_content = "SELECT * FROM `content` WHERE id = '$comment_id'";
               $select_content_result = mysqli_query($conn, $select_content);
               $fetch_content = mysqli_fetch_assoc( $select_content_result);
      ?>
      <div class="box" style="<?php if($fetch_comment['tutor_id'] == $tutor_id){echo 'order:-1;';} ?>">
         <div class="content"><span><?= $fetch_comment['date']; ?></span><p> - <?= $fetch_content['title']; ?> - </p><a href="view_content.php?get_id=<?= $fetch_content['id']; ?>">view content</a></div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <form action="" method="post">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">delete comment</button>
         </form>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">no comments added yet!</p>';
      }
      ?>
      </div>
   
</section>














<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>