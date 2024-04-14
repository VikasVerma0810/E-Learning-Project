
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tutor Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php  
    include "./components/user_header.php";
?>

<?php


    // if(isset($_COOKIE['user_id'])){
    //    $user_id = $_COOKIE['user_id'];
    // }else{
    //    $user_id = '';
    // }

    if(isset($_POST['tutor_fetch'])){

    $tutor_email = $_POST['tutor_email'];
    $select_tutor = "SELECT * FROM `tutors` WHERE email = '$tutor_email'";
    $select_tutor_result = mysqli_query($conn, $select_tutor);

    $fetch_tutor = mysqli_fetch_assoc($select_tutor_result);
    $tutor_id = $fetch_tutor['id'];

    $count_playlists = "SELECT * FROM `playlist` WHERE tutor_id = '$tutor_id'";
    $count_playlists_result = mysqli_query($conn, $count_playlists);
    $total_playlists = mysqli_num_rows($count_playlists_result);

    $count_contents = "SELECT * FROM `content` WHERE tutor_id = '$tutor_id'";
    $count_contents_result  = mysqli_query($conn, $count_contents);
    $total_contents = mysqli_num_rows($count_contents_result);

    $count_likes = "SELECT * FROM `likes` WHERE tutor_id = '$tutor_id'";
    $count_likes_result  = mysqli_query($conn, $count_likes);
    $total_likes = mysqli_num_rows($count_likes_result);

    $count_comments = "SELECT * FROM `comments` WHERE tutor_id = '$tutor_id'";
    $count_comments_result = mysqli_query($conn, $count_comments);
    $total_comments = mysqli_num_rows($count_comments_result);

    }else{
    header('location:teachers.php');
    }

?>


<!-- teachers profile section starts  -->

<section class="teacher-profile">

   <h1 class="heading">profile details</h1>

   <div class="details">
      <div class="tutor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <h3><?= $fetch_tutor['name']; ?></h3>
         <span><?= $fetch_tutor['profession']; ?></span>
      </div>
      <div class="flex">
         <p>total playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents; ?></span></p>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <p>total comments : <span><?= $total_comments; ?></span></p>
      </div>
   </div>

</section>

<!-- teachers profile section ends -->

<section class="courses">

   <h1 class="heading">latest courese</h1>

   <div class="box-container">

      <?php
         $select_courses = "SELECT * FROM `playlist` WHERE tutor_id = '$tutor_id' AND status = 'active'";
         $select_courses_result = mysqli_query($conn, $select_courses);
         if(mysqli_num_rows($select_courses_result) > 0){
            while($fetch_course = mysqli_fetch_assoc($select_courses_result)){
               $course_id = $fetch_course['id'];
                $tutor_id = $fetch_course['tutor_id'];
               $select_tutor = "SELECT * FROM `tutors` WHERE id = '$tutor_id'";
               $select_tutor_result = mysqli_query($conn, $select_tutor);
               $fetch_tutor = mysqli_fetch_assoc($select_tutor_result);
      ?>
      <div class="box">
        <div class="thumb"> 
            <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
        </div>
         <h3 class="title"><?= $fetch_course['title']; ?></h3>

         <a href="playlist.php?playlist_id=<?= $course_id?>&tutor_id=<?= $tutor_id ?>" class="inline-btn">view playlist</a>
         <!-- <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a> -->
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no courses added yet!</p>';
      }
      ?>

   </div>

</section>

<!-- courses section ends -->

<?php include "./components/footer.php" ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>


<!-- Start of ChatBot (www.chatbot.com) code -->
<script type="text/javascript">
      window.__be = window.__be || {};
      window.__be.id = "661c01e6dfd0a90007de6739";
      (function () {
         var be = document.createElement('script'); be.type = 'text/javascript'; be.async = true;
         be.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.chatbot.com/widget/plugin.js';
         var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(be, s);
      })();
   </script>
   <noscript>You need to <a href="https://www.chatbot.com/help/chat-widget/enable-javascript-in-your-browser/"
         rel="noopener nofollow">enable JavaScript</a> in order to use the AI chatbot tool powered by <a
         href="https://www.chatbot.com/" rel="noopener nofollow" target="_blank">ChatBot</a></noscript>
   <!-- End of ChatBot code -->

</body>
</html>