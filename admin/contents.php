<?php

include '../components/dbconnect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $verify_video = "SELECT * FROM `content` WHERE id = '$delete_id' LIMIT 1";
   $verify_video_result = mysqli_query($conn, $verify_video );
   if(mysqli_num_rows($verify_video_result) > 0){
      $delete_video_thumb = "SELECT * FROM `content` WHERE id = '$delete_id' LIMIT 1";
      $delete_video_thumb_result = mysqli_query($conn, $delete_video_thumb);
      $fetch_thumb = mysqli_fetch_assoc($delete_video_thumb_result);
      unlink('../uploaded_files/'.$fetch_thumb['thumb']);
      $delete_video = "SELECT * FROM `content` WHERE id = '$delete_id' LIMIT 1";
      $delete_video_result = mysqli_query($conn, $delete_video);
      $fetch_video = mysqli_fetch_assoc($delete_video_result);
      unlink('../uploaded_files/'.$fetch_video['video']);
      $delete_likes = "DELETE FROM `likes` WHERE content_id = '$delete_id'";
      $delete_likes_result = mysqli_query($conn, $delete_likes);
      $delete_comments = "DELETE FROM `comments` WHERE content_id = '$delete_id'";
      $delete_comments_result = mysqli_query($conn, $delete_comments);
      $delete_content = "DELETE FROM `content` WHERE id = '$delete_id'";
      $delete_content_result = mysqli_query($conn, $delete_content);
      $message[] = 'video deleted!';
   }else{
      $message[] = 'video already deleted!';
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
   
<section class="contents">

   <h1 class="heading">your contents</h1>

   <div class="box-container">

   <div class="box" style="text-align: center;">
      <h3 class="title" style="margin-bottom: .5rem;">create new content</h3>
      <a href="add_content.php" class="btn">add content</a>
   </div>

   <?php
      $select_videos = "SELECT * FROM `content` WHERE tutor_id = '$tutor_id' ORDER BY date DESC";
      $select_videos_result = mysqli_query($conn, $select_videos);
      if(mysqli_num_rows($select_videos_result) > 0){
         while($fecth_videos = mysqli_fetch_assoc($select_videos_result)){ 
            $video_id = $fecth_videos['id'];
   ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fecth_videos['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fecth_videos['date']; ?></span></div>
         </div>
         <img src="../uploaded_files/<?= $fecth_videos['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fecth_videos['title']; ?></h3>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
         </form>
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">view content</a>
      </div>
   <?php
         }
      }else{
         echo '<p class="empty">no contents added yet!</p>';
      }
   ?>

   </div>

</section>



<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>