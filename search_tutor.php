

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search tutor</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include './components/user_header.php'; ?>
<?php


    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    }else{
    $user_id = '';
    }

?>
<section class="teachers">

   <h1 class="heading">expert tutors</h1>

   <form action="" method="post" class="search-tutor">
      <input type="text" name="search_tutor" maxlength="100" placeholder="search tutor..." required>
      <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">

      <?php
         if(isset($_POST['search_tutor']) or isset($_POST['search_tutor_btn'])){
            $search_tutor = $_POST['search_tutor'];
            $select_tutors = "SELECT * FROM `tutors` WHERE name LIKE '%{$search_tutor}%'";
            $select_tutors_result = mysqli_query($conn, $select_tutors);
            if(mysqli_num_rows($select_tutors_result) > 0){
               while($fetch_tutor = mysqli_fetch_assoc($select_tutors_result)){

                  $tutor_id = $fetch_tutor['id'];

                  $count_playlists = "SELECT * FROM `playlist` WHERE tutor_id = '$tutor_id'";
                  $count_playlists_result = mysqli_query($conn, $count_playlists);
                  $total_playlists = mysqli_num_rows($count_playlists_result);

                  $count_contents = "SELECT * FROM `content` WHERE tutor_id = '$tutor_id'";
                  $count_contents_result = mysqli_query($conn, $count_contents);
                  $total_contents = mysqli_num_rows( $count_contents_result);

                  $count_likes = "SELECT * FROM `likes` WHERE tutor_id = '$tutor_id'";
                  $count_likes_result = mysqli_query($conn, $count_likes);
                  $total_likes = mysqli_num_rows($count_likes_result);

                  $count_comments = "SELECT * FROM `comments` WHERE tutor_id ='$tutor_id' ";
                  $count_comments_result = mysqli_query($conn, $count_comments);
                  $total_comments = mysqli_num_rows($count_comments_result);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_tutor['profession']; ?></span>
            </div>
         </div>
         <p>playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents ?></span></p>
         <p>total likes : <span><?= $total_likes ?></span></p>
         <p>total comments : <span><?= $total_comments ?></span></p>
         <form action="tutor_profile.php" method="post">
            <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
            <input type="submit" value="view profile" name="tutor_fetch" class="inline-btn">
         </form>
      </div>
      <?php
               }
            }else{
               echo '<p class="empty">no results found!</p>';
            }
         }else{
            echo '<p class="empty">please search something!</p>';
         }
      ?>

   </div>

</section>

<!-- teachers section ends -->


<?php include 'components/footer.php'; ?>

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