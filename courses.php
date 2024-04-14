

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Courses List</title>

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

<section class="courses">

   <h1 class="heading">our courses</h1>

   <div class="box-container">

   <?php
        $select_course = "select * from playlist where status = 'active'";
        $course_result = mysqli_query($conn, $select_course);
        $course_count = mysqli_num_rows($course_result);

        if($course_count>0){

            while($course_row = mysqli_fetch_assoc($course_result)){
                $tutor_id = $course_row['tutor_id'];

                $select_tutor = "select * from tutors where id ='$tutor_id '";
                $tutor_result = mysqli_query($conn, $select_tutor);
                $tutor_row  = mysqli_fetch_assoc($tutor_result);
                
            echo'<div class="box">
                    <div class="tutor">
                        <img src="uploaded_files/'.$tutor_row["image"].'" alt="">
                        <div class="info">';
                            //   <h3>'.$tutor_row["name"].' </h3>
                            if($course_row["premium"] == "yes"){
                                echo '<h3>'.$tutor_row["name"].'<i class="fa-solid fa-crown" style="color:#FFD700"></i> </h3>';
                            }else{
                                echo '<h3>'.$tutor_row["name"].'</h3>'; 
                            }
                            echo '<span>04-11-2023</span>
                        </div>
                    </div>
                    <div class="thumb">
                    <img src="uploaded_files/'.$course_row["thumb"].'" alt="">
                    <span>10 videos</span>
                    </div>
                    <h3 class="title">'.$course_row["title"].'</h3>

                    <a href="playlist.php?playlist_id='.$course_row["id"].'&tutor_id='.$tutor_id.'&isPremium='.$course_row["premium"].'" class="inline-btn">view playlist</a>

                </div>';
            }
            

        }else{
            echo '<p style=" background-color: var(--white);border-radius: .5rem; padding: 1.5rem; text-align: center  width: 100%;font-size: 2rem; color: var(--red);">no courses added yet!</p>';  
        }
   ?>


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

</body>
</html>