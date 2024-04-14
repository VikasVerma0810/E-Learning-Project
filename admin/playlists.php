<?php

include '../components/dbconnect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $delete_id = $_POST['playlist_id'];

   $verify_playlist = "SELECT * FROM `playlist` WHERE id = '$delete_id' AND tutor_id = '$tutor_id' LIMIT 1";
   $verify_playlist_result = mysqli_query($conn, $verify_playlist);
   
   if(mysqli_num_rows($verify_playlist_result) > 0){

      $delete_playlist_thumb = "SELECT * FROM `playlist` WHERE id = '$delete_id' LIMIT 1";
      $delete_playlist_result = mysqli_query($conn, $delete_playlist_thumb);
      $fetch_thumb = mysqli_fetch_assoc($delete_playlist_result);

      unlink('../uploaded_files/'.$fetch_thumb['thumb']);

      $delete_bookmark = "DELETE FROM `bookmark` WHERE playlist_id = '$delete_id'";
      $delete_bookmark = mysqli_query($conn, $delete_bookmark);
    
      $delete_playlist = "DELETE FROM `playlist` WHERE id = '$delete_id'";
      $delete_playlist = mysqli_query($conn, $delete_playlist);
   
      $message[] = 'playlist deleted!';
   }else{
      $message[] = 'playlist already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Playlists</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="playlists">

   <h1 class="heading">added playlists</h1>

   <div class="box-container">
   
      <div class="box" style="text-align: center;">
         <h3 class="title" style="margin-bottom: .5rem;">create new playlist</h3>
         <a href="add_playlist.php" class="btn">add playlist</a>
      </div>

      <?php
         $select_playlist = "SELECT * FROM `playlist` WHERE tutor_id = '$tutor_id' ORDER BY date DESC";
         $select_playlist_result = mysqli_query($conn, $select_playlist);
    
         if(mysqli_num_rows($select_playlist_result) > 0){
         while($fetch_playlist = mysqli_fetch_assoc($select_playlist_result)){
            $playlist_id = $fetch_playlist['id'];
            $count_videos = "SELECT * FROM `content` WHERE playlist_id = '$playlist_id'";
            $count_videos_result = mysqli_query($conn, $count_videos);
            $total_videos = mysqli_num_rows($count_videos_result);
      ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-circle-dot" style="<?php if($fetch_playlist['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_playlist['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_playlist['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         </div>
         <div class="thumb">
            <span><?= $total_videos; ?></span>
            <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
         </div>
         <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
         <p class="description"><?= $fetch_playlist['description']; ?></p>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
            <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this playlist?');" name="delete">
         </form>
         <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">view playlist</a>
      </div>
      <?php
         } 
      }else{
         echo '<p class="empty">no playlist added yet!</p>';
      }
      ?>

   </div>

</section>













<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

</body>
</html>