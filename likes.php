
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>liked videos</title>

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
    header('location:home.php');
    }

    if(isset($_POST['remove'])){

    if($user_id != ''){
        $content_id = $_POST['content_id'];

        $verify_likes = "SELECT * FROM `likes` WHERE user_id = '$user_id' AND content_id = '$content_id'";
        $verify_likes_result = mysqli_query($conn, $verify_likes);

        if(mysqli_num_rows($verify_likes_result) > 0){
            $remove_likes = "DELETE FROM `likes` WHERE user_id = '$user_id' AND content_id = '$content_id'";
            $remove_likes_result =  mysqli_query($conn, $remove_likes);;
            $message[] = 'removed from likes!';
        }
    }else{
        $message[] = 'please login first!';
    }

    }

?>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">liked videos</h1>

   <div class="box-container">

   <?php
      $select_likes = "SELECT * FROM `likes` WHERE user_id = '$user_id'";
      $select_likes_result = mysqli_query($conn, $select_likes);
      if(mysqli_num_rows($select_likes_result) > 0){
         while($fetch_likes = mysqli_fetch_assoc($select_likes_result)){

            $content_id = $fetch_likes['content_id'];
            $select_contents = "SELECT * FROM `content` WHERE id = ' $content_id' ORDER BY date DESC";
            $select_contents_result = mysqli_query($conn, $select_contents);

            if(mysqli_num_rows($select_contents_result) > 0){
               while($fetch_contents = mysqli_fetch_assoc($select_contents_result)){

                $utor_id =  $fetch_contents['tutor_id'];
               $select_tutors = "SELECT * FROM `tutors` WHERE id = ' $utor_id '";
               $select_tutors_result = mysqli_query($conn, $select_tutors);
               $fetch_tutor =mysqli_fetch_assoc( $select_tutors_result);
   ?>
   <div class="box">
      <div class="tutor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div class="info">
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_contents['date']; ?></span>
         </div>
      </div>
      <div class="thumb">
        <img src="uploaded_files/<?= $fetch_contents['thumb']; ?>" alt="" class="thumb">
     </div>
      <h3 class="title"><?= $fetch_contents['title']; ?></h3>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="content_id" value="<?= $fetch_contents['id']; ?>">
         
         <a href="watch-video.php?video_id=<?= $fetch_contents['id']; ?>" class="inline-btn">watch video</a>
         <input type="submit" value="remove" class="inline-delete-btn" name="remove">
      </form>
   </div>
   <?php
            }
         }else{
            echo '<p style="background-color: var(--white);
            border-radius: .5rem;
            padding: 1.5rem;
            text-align: center;
            width: 100%;
            font-size: 2rem;
            color: var(--red);">content was not found!</p>';         
         }
      }
   }else{
      echo '<p style="background-color: var(--white);
      border-radius: .5rem;
      padding: 1.5rem;
      text-align: center;
      width: 100%;
      font-size: 2rem;
      color: var(--red);">nothing added to likes yet!</p>';
   }
   ?>

   </div>

</section>


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