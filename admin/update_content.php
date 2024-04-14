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
   header('location:dashboard.php');
}

if(isset($_POST['update'])){

   $video_id = $_POST['video_id'];
   $status = $_POST['status'];
   $title = $_POST['title'];
   $description = $_POST['description'];
   $playlist = $_POST['playlist'];

   $update_content =  "UPDATE `content` SET title = '$title', description = '$description', status = '$status' WHERE id = '$video_id'";
   $update_content_result = mysqli_query($conn, $update_content);

   if(!empty($playlist)){
      $update_playlist = "UPDATE `content` SET playlist_id = '$playlist' WHERE id = '$video_id'";
      $update_playlist_result = mysqli_query($conn, $update_playlist);
   }

   $old_thumb = $_POST['old_thumb'];
   $thumb = $_FILES['thumb']['name'];
   $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
   $rename_thumb = unique_id().'.'.$thumb_ext;
   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../uploaded_files/'.$rename_thumb;

   if(!empty($thumb)){
      if($thumb_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_thumb = "UPDATE `content` SET thumb = '$rename_thumb' WHERE id = '$video_id'";
         $update_thumb_result = mysqli_query($conn, $update_thumb);
         move_uploaded_file($thumb_tmp_name, $thumb_folder);
         if($old_thumb != '' AND $old_thumb != $rename_thumb){
            unlink('../uploaded_files/'.$old_thumb);
         }
      }
   }

   $old_video = $_POST['old_video'];
   $video = $_FILES['video']['name'];
   $video_ext = pathinfo($video, PATHINFO_EXTENSION);
   $rename_video = unique_id().'.'.$video_ext;
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $video_folder = '../uploaded_files/'.$rename_video;

   if(!empty($video)){
      $update_video = "UPDATE `content` SET video = '$rename_video' WHERE id = '$video_id'";
      $update_video_result = mysqli_query($conn, $update_video);
      move_uploaded_file($video_tmp_name, $video_folder);
      if($old_video != '' AND $old_video != $rename_video){
         unlink('../uploaded_files/'.$old_video);
      }
   }

   $message[] = 'content updated!';

}

if(isset($_POST['delete_video'])){

   $delete_id = $_POST['video_id'];

   $delete_video_thumb = "SELECT thumb FROM `content` WHERE id = '$delete_id' LIMIT 1";
   $delete_video_thumb_result = mysqli_query($conn, $delete_video_thumb);
   $fetch_thumb = mysqli_fetch_assoc($delete_video_thumb_result);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);

   $delete_video = "SELECT video FROM `content` WHERE id = '$delete_id' LIMIT 1";
   $delete_video_result = mysqli_query($conn, $delete_video);
   $fetch_video = mysqli_fetch_assoc($delete_video_result);
   unlink('../uploaded_files/'.$fetch_video['video']);

   $delete_likes = "DELETE FROM `likes` WHERE content_id = ?";
   $delete_likes_result = mysqli_query($conn, $delete_likes);
   $delete_comments = "DELETE FROM `comments` WHERE content_id = '$delete_id'";
   $delete_comments_result = mysqli_query($conn, $delete_comments);

   $delete_content = "DELETE FROM `content` WHERE id = '$delete_id'";
   $delete_content_result = mysqli_query($conn, $delete_content);
   header('location:contents.php');
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update video</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="video-form">

   <h1 class="heading">update content</h1>

   <?php
      $select_videos = "SELECT * FROM `content` WHERE id = '$get_id' AND tutor_id = '$tutor_id'";
      $select_videos_result = mysqli_query($conn, $select_videos);
      if(mysqli_num_rows($select_videos_result)> 0){
         while($fecth_videos = mysqli_fetch_assoc($select_videos_result)){ 
            $video_id = $fecth_videos['id'];
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="video_id" value="<?= $fecth_videos['id']; ?>">
      <input type="hidden" name="old_thumb" value="<?= $fecth_videos['thumb']; ?>">
      <input type="hidden" name="old_video" value="<?= $fecth_videos['video']; ?>">
      <p>update status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="<?= $fecth_videos['status']; ?>" selected><?= $fecth_videos['status']; ?></option>
         <option value="active">active</option>
         <option value="deactive">deactive</option>
      </select>
      <p>update title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter video title" class="box" value="<?= $fecth_videos['title']; ?>">
      <p>update description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30" rows="10"><?= $fecth_videos['description']; ?></textarea>
      <p>update playlist</p>
      <select name="playlist" class="box">
         <option value="<?= $fecth_videos['playlist_id']; ?>" selected>--select playlist</option>
         <?php
         $select_playlists = "SELECT * FROM `playlist` WHERE tutor_id = '$tutor_id'";
         $select_playlists_result = mysqli_query($conn, $select_playlists);
         if(mysqli_num_rows($select_playlists_result) > 0){
            while($fetch_playlist = mysqli_fetch_assoc($select_playlists_result)){
         ?>
         <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
         <?php
            }
         ?>
         <?php
         }else{
            echo '<option value="" disabled>no playlist created yet!</option>';
         }
         ?>
      </select>
      <img src="../uploaded_files/<?= $fecth_videos['thumb']; ?>" alt="">
      <p>update thumbnail</p>
      <input type="file" name="thumb" accept="image/*" class="box">
      <video src="../uploaded_files/<?= $fecth_videos['video']; ?>" controls></video>
      <p>update video</p>
      <input type="file" name="video" accept="video/*" class="box">
      <input type="submit" value="update content" name="update" class="btn">
      <div class="flex-btn">
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="option-btn">view content</a>
         <input type="submit" value="delete content" name="delete_video" class="delete-btn">
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">video not found! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
      }
   ?>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>