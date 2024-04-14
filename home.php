<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

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

   if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
   } else {
      $user_id = '';
   }


   // $user_id = $_SESSION['user_id'];
   $select_likes = "SELECT * FROM `likes` WHERE user_id = '$user_id'";
   $select_likes_result = mysqli_query($conn, $select_likes);
   $total_likes = mysqli_num_rows($select_likes_result);

   $select_comments = "SELECT * FROM `comments` WHERE user_id = '$user_id'";
   $select_comments_result = mysqli_query($conn, $select_comments);
   $total_comments = mysqli_num_rows($select_comments_result);

   $select_bookmark = "SELECT * FROM `bookmark` WHERE user_id = '$user_id'";
   $select_bookmark_result = mysqli_query($conn, $select_bookmark);
   $total_bookmarked = mysqli_num_rows($select_bookmark_result);

   ?>

   <section class="home-grid">

      <h1 class="heading">quick options</h1>

      <div class="box-container">

         <?php
         if ($user_id != '') {
            ?>
            <div class="box">
               <h3 class="title">likes and comments</h3>
               <p class="likes">total likes : <span><?= $total_likes; ?></span></p>
               <a href="likes.php" class="inline-btn">view likes</a>
               <p class="likes">total comments : <span><?= $total_comments; ?></span></p>
               <a href="comments.php" class="inline-btn">view comments</a>
               <p class="likes">saved playlist : <span><?= $total_bookmarked; ?></span></p>
               <a href="bookmark.php" class="inline-btn">view bookmark</a>
            </div>
            <?php
         } else {
            ?>
            <div class="box" style="text-align: center;">
               <h3 class="title">please login or register</h3>
               <div class="flex-btn" style="padding-top: .5rem;">
                  <a href="login.php" class="option-btn">login</a>
                  <a href="register.php" class="option-btn">register</a>
               </div>
            </div>
            <?php
         }
         ?>

         <div class="box">
            <h3 class="title">top categories</h3>
            <div class="flex">
               <a href="#"><i class="fas fa-code"></i><span>development</span></a>
               <a href="#"><i class="fas fa-chart-simple"></i><span>business</span></a>
               <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
               <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
               <a href="#"><i class="fas fa-music"></i><span>music</span></a>
               <a href="#"><i class="fas fa-camera"></i><span>photography</span></a>
               <a href="#"><i class="fas fa-cog"></i><span>software</span></a>
               <a href="#"><i class="fas fa-vial"></i><span>science</span></a>
            </div>
         </div>

         <div class="box">
            <h3 class="title">popular topics</h3>
            <div class="flex">
               <a href="#"><i class="fab fa-html5"></i><span>HTML</span></a>
               <a href="#"><i class="fab fa-css3"></i><span>CSS</span></a>
               <a href="#"><i class="fab fa-js"></i><span>javascript</span></a>
               <a href="#"><i class="fab fa-react"></i><span>react</span></a>
               <a href="#"><i class="fab fa-php"></i><span>PHP</span></a>
               <a href="#"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a>
            </div>
         </div>

         <div class="box">
            <h3 class="title">become a tutor</h3>
            <p class="tutor">Ready to share your expertise and inspire others? Click here to become a tutor on our
               platform and help shape the future of education!</p>
            <a href="admin/register.php" class="inline-btn">get started</a>
         </div>

      </div>

   </section>



   <section class="courses">

      <h1 class="heading">latest courses</h1>

      <div class="box-container">

         <?php
         $select_courses = "SELECT * FROM `playlist` WHERE status = 'active' ORDER BY date DESC LIMIT 6";
         $select_courses_result = mysqli_query($conn, $select_courses);
         if (mysqli_num_rows($select_courses_result) > 0) {
            while ($fetch_course = mysqli_fetch_assoc($select_courses_result)) {
               $course_id = $fetch_course['id'];

               $tutor_id = $fetch_course['tutor_id'];
               $select_tutor = "SELECT * FROM `tutors` WHERE id = '$tutor_id '";
               $select_tutor_result = mysqli_query($conn, $select_tutor);
               $fetch_tutor = mysqli_fetch_assoc($select_tutor_result);
               ?>
               <div class="box">
                  <div class="tutor">
                     <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                     <div class="info">
                        <h3><?= $fetch_tutor['name']; ?></h3>
                        <span><?= $fetch_course['date']; ?></span>
                     </div>
                  </div>
                  <div class="thumb">
                     <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
                  </div>
                  <h3 class="title"><?= $fetch_course['title']; ?></h3>
                  <a href="playlist.php?playlist_id=<?= $course_id; ?>&tutor_id=<?= $tutor_id ?>" class="inline-btn">view
                     playlist</a>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty">no courses added yet!</p>';
         }
         ?>

      </div>

      <div class="more-btn">
         <a href="courses.php" class="inline-option-btn">view more</a>
      </div>

   </section>



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