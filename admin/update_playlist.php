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

if(isset($_POST['submit'])){

   $title = $_POST['title'];
   $description = $_POST['description'];
   $status = $_POST['status'];

   $update_playlist = "UPDATE `playlist` SET title = '$title', description = ' $description', status = '$status' WHERE id = '$get_id'";
   $update_playlist_result = mysqli_query($conn, $update_playlist);

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = "UPDATE `playlist` SET thumb = '$rename' WHERE id = '$get_id'";
         $update_image_result = mysqli_query($conn, $update_image);
         move_uploaded_file($image_tmp_name, $image_folder);
         if($old_image != '' AND $old_image != $rename){
            unlink('../uploaded_files/'.$old_image);
         }
      }
   } 

   $message[] = 'playlist updated!';  

}

if(isset($_POST['delete'])){
   $delete_id = $_POST['playlist_id'];
   $delete_playlist_thumb = "SELECT * FROM `playlist` WHERE id = '$delete_id' LIMIT 1";
   $delete_playlist_thumb_result = mysqli_query($conn,  $delete_playlist_thumb);
   $fetch_thumb = mysqli_fetch_assoc( $delete_playlist_thumb_result);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);
   $delete_bookmark = "DELETE FROM `bookmark` WHERE playlist_id = '$delete_id'";
   $delete_bookmark_result =  mysqli_query($conn,  $delete_bookmark);
   $delete_playlist = "DELETE FROM `playlist` WHERE id = '$delete_id'";
   $delete_playlist_result = mysqli_query($conn,$delete_playlist );
   header('location:playlists.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Playlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="playlist-form">

   <h1 class="heading">update playlist</h1>

   <?php
         $select_playlist = "SELECT * FROM `playlist` WHERE id = '$get_id'";
         $select_playlist_result = mysqli_query($conn, $select_playlist);
         if(mysqli_num_rows( $select_playlist_result ) > 0){
         while($fetch_playlist = mysqli_fetch_assoc( $select_playlist_result )){
            $playlist_id = $fetch_playlist['id'];
            $count_videos = "SELECT * FROM `content` WHERE playlist_id = '$playlist_id'";
            $count_videos_result = mysqli_query($conn, $count_videos);
            $total_videos = mysqli_num_rows( $count_videos_result);
      ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_playlist['thumb']; ?>">
      <p>playlist status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="<?= $fetch_playlist['status']; ?>" selected><?= $fetch_playlist['status']; ?></option>
         <option value="active">active</option>
         <option value="deactive">deactive</option>
      </select>
      <p>playlist title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter playlist title" value="<?= $fetch_playlist['title']; ?>" class="box">
      <p>playlist description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30" rows="10"><?= $fetch_playlist['description']; ?></textarea>
      <p>playlist thumbnail <span>*</span></p>
      <div class="thumb">
         <span><?= $total_videos; ?></span>
         <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
      </div>
      <input type="file" name="image" accept="image/*" class="box">
      <input type="submit" value="update playlist" name="submit" class="btn">
      <div class="flex-btn">
         <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this playlist?');" name="delete">
         <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="option-btn">view playlist</a>
      </div>
   </form>
   <?php
      } 
   }else{
      echo '<p class="empty">no playlist added yet!</p>';
   }
   ?>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>