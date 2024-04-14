<?php

include '../components/dbconnect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:playlist.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $delete_id = $_POST['playlist_id'];
   $delete_playlist_thumb = "SELECT * FROM `playlist` WHERE id = '$delete_id' LIMIT 1";
   $delete_playlist_thumb_result = mysqli_query($conn, $delete_playlist_thumb);
   $fetch_thumb = mysqli_fetch_assoc($delete_playlist_thumb_result);

   // unlink('C:\xampp\htdocs\SDL\project\uploaded_files/'.$fetch_thumb['thumb']);

   $delete_bookmark = "DELETE FROM `bookmark` WHERE playlist_id = '$delete_id'";
   $delete_bookmark_result = mysqli_query($conn, $delete_bookmark);

   $delete_playlist = "DELETE FROM `playlist` WHERE id = '$delete_id'";
   $delete_playlist_result = mysqli_query($conn, $delete_playlist);
   header('locatin:playlists.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $delete_id = $_POST['video_id'];
   $verify_video = "SELECT * FROM `content` WHERE id = '$delete_id' LIMIT 1";
   $verify_video_result = mysqli_query($conn, $verify_video);
   
   if(mysqli_num_rows($verify_video_result) > 0){
      $delete_video_thumb = "SELECT * FROM `content` WHERE id = '$delete_id' LIMIT 1";
      $delete_video_thumb_result = mysqli_query($conn, $delete_video_thumb);

      $fetch_thumb = mysqli_fetch_assoc($delete_video_thumb_result);
      unlink('../uploaded_files/'.$fetch_thumb['thumb']);

      $delete_video = "SELECT * FROM `content` WHERE id = '$delete_id' LIMIT 1";
      $delete_video_result = mysqli_query($conn, $delete_video);
    
      $fetch_video = mysqli_fetch_assoc($delete_video_result);
      unlink('../uploaded_files/'.$fetch_video['video']);

      $delete_likes =  "DELETE FROM `likes` WHERE content_id = '$delete_id'";
      $delete_likes_result = mysqli_query($conn, $delete_likes);

      $delete_comments = "DELETE FROM `comments` WHERE content_id = '$delete_id'";
      $delete_comments_result =  mysqli_query($conn, $delete_comments);

      $delete_content = "DELETE FROM `content` WHERE id = '$delete_id'";
      $delete_content_result =  mysqli_query($conn, $delete_content);
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
   <title>Playlist Details</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="playlist-details">

   <h1 class="heading">playlist details</h1>

   <?php
      $select_playlist = "SELECT * FROM `playlist` WHERE id = '$get_id' AND tutor_id = '$tutor_id'";
      $select_playlist_result  = mysqli_query($conn, $select_playlist);

      if(mysqli_num_rows($select_playlist_result) > 0){
         while($fetch_playlist = mysqli_fetch_assoc($select_playlist_result)){
            $playlist_id = $fetch_playlist['id'];
            $count_videos = "SELECT * FROM `content` WHERE playlist_id = '$playlist_id'";
            $count_videos_result = mysqli_query($conn, $count_videos);
            $total_videos = mysqli_num_rows($count_videos_result);
   ?>
   <div class="row">
      <div class="thumb">
         <span><?= $total_videos; ?></span>
         <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
      </div>
      <div class="details">
         <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         <div class="description"><?= $fetch_playlist['description']; ?></div>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
            <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="option-btn">update playlist</a>
            <input type="submit" value="delete playlist" class="delete-btn" onclick="return confirm('delete this playlist?');" name="delete">
         </form>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no playlist found!</p>';
      }
   ?>

</section>

<section class="contents">

   <h1 class="heading">playlist videos</h1>

   <div class="box-container">

   <?php
      $playlist_id = $_GET['get_id'];
      $select_videos = "SELECT * FROM `content` WHERE tutor_id = '$tutor_id' AND playlist_id = '$playlist_id'";
      $select_videos_result = mysqli_query($conn, $select_videos);
      if(mysqli_num_rows($select_videos_result) > 0){
         while($fecth_videos = mysqli_fetch_assoc($select_videos_result)){ 
            $video_id = $fecth_videos['id'];
   ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fecth_videos['status'] == 'active'){
               echo 'color:limegreen'; }
               else{
                  echo 'color:red';} 
               ?>">
               </i><span style="<?php if($fecth_videos['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fecth_videos['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fecth_videos['date']; ?></span></div>
         </div>
         <img src="../uploaded_files/<?= $fecth_videos['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fecth_videos['title']; ?></h3>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
         </form>
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">watch video</a>
      </div>
      
   <?php
         }
      }else{
         echo '<p class="empty">no videos added yet! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
      }
   ?>
   <?php 
    echo '<p > <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';?>

   </div>

   

</section>



<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>