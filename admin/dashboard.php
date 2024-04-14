<?php

include '../components/dbconnect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}


$select_playlists = "SELECT * FROM `playlist` WHERE tutor_id = '$tutor_id'";
$playlists_result = mysqli_query($conn, $select_playlists);
$total_playlists = mysqli_num_rows($playlists_result);


$select_contents = "SELECT * FROM `content` WHERE tutor_id = '$tutor_id'";
$contents_result = mysqli_query($conn, $select_contents);
$total_contents = mysqli_num_rows($contents_result);

$select_likes = "SELECT * FROM `likes` WHERE tutor_id = '$tutor_id'";
$likes_result = mysqli_query($conn, $select_likes);
$total_likes = mysqli_num_rows($likes_result);


$select_comments = "SELECT * FROM `comments` WHERE tutor_id = '$tutor_id'";
$comments_result = mysqli_query($conn, $select_comments);
$total_comments = mysqli_num_rows($comments_result);

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
   
<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>welcome!</h3>
         <p><?= $profile_row['name']; ?></p>
         <a href="profile.php" class="btn">view profile</a>
      </div>

      <div class="box">
         <h3><?= $total_contents; ?></h3>
         <p>total contents</p>
         <a href="add_content.php" class="btn">add new content</a>
      </div>

      <div class="box">
         <h3><?= $total_playlists; ?></h3>
         <p>total playlists</p>
         <a href="add_playlist.php" class="btn">add new playlist</a>
      </div>

      <div class="box">
         <h3><?= $total_likes; ?></h3>
         <p>total likes</p>
         <a href="contents.php" class="btn">view contents</a>
      </div>

      <div class="box">
         <h3><?= $total_comments; ?></h3>
         <p>total comments</p>
         <a href="comments.php" class="btn">view comments</a>
      </div>


   </div>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>