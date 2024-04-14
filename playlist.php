<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include "./components/user_header.php"; ?>

    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                $user_id = $_SESSION['user_id'];
                $playlist_id =  $_GET['playlist_id'];

                $select_bookmark = "insert into bookmark (user_id, playlist_id) values('$user_id', '$playlist_id')";
                $bookmark_result = mysqli_query($conn, $select_bookmark);
            }else{
                header("location:login.php");
            }
        }
    ?>

    <section class="playlist-details">

        <h1 class="heading">playlist details</h1>

        <div class="row">

            <div class="column">
                <form action="" method="post" class="save-playlist">
                    <button type="submit"><i class="far fa-bookmark"></i> <span>save playlist</span></button>
                </form>

                <?php
                $playlist_id =  $_GET['playlist_id'];
                $tutor_id = $_GET['tutor_id'];

                $select_playlist = "select * from playlist where id = '$playlist_id'";
                $playlist_result = mysqli_query($conn, $select_playlist);
                $fetch_playlist = mysqli_fetch_assoc($playlist_result);

                $select_tutor = "select * from tutors where id = '$tutor_id'";
                $tutor_result = mysqli_query($conn, $select_tutor);
                $fetch_tutor = mysqli_fetch_assoc($tutor_result);


                $count_video_query = "select * from content where playlist_id = '$playlist_id'";
                $count_video_result = mysqli_query($conn, $count_video_query);
                $count_video = mysqli_num_rows($count_video_result);

                echo  '<div class="thumb">
                    <img src="uploaded_files/' . $fetch_playlist["thumb"] . '" alt="">
                    <span>'.$count_video.' videos</span>
                </div>
            </div>
            <div class="column">
            <div class="tutor">
               <img src="uploaded_files/' . $fetch_tutor["image"] . '" alt="">
               <div>';
                    if($fetch_playlist["premium"] == "yes"){
                        echo '<h3>'.$fetch_tutor["name"].'<i class="fa-solid fa-crown" style="color:#FFD700"></i> </h3>';
                    }else{
                        echo '<h3>'.$fetch_tutor["name"].'</h3>'; 
                    }


                 echo '
                  <span>' . $fetch_playlist['date'] . '</span>
               </div>
            </div>
      
            <div class="details">
               <h3>' . $fetch_playlist['title'] . '</h3>
               <p>' . $fetch_playlist['description'] . '</p>

               <form action="tutor_profile.php" method="post">
                    <input type="hidden" name="tutor_email" value="' . $fetch_tutor["email"] . '">
                    <input type="submit" value="view profile" name="tutor_fetch" class="inline-btn">
                </form>
            </div>
         </div>';

                ?>
            </div>

    </section>



    <section class="playlist-videos">

        <h1 class="heading">playlist videos</h1>

        <div class="box-container">

            <?php
            $playlist_id =  $_GET['playlist_id'];
            $tutor_id = $_GET['tutor_id'];
            $isPremium = $_GET['isPremium'];

            $select_video = "SELECT * FROM `content` WHERE playlist_id ='$playlist_id'  AND status = 'active' ORDER BY id DESC";
            $video_result = mysqli_query($conn, $select_video);

            while($fetch_video = mysqli_fetch_assoc($video_result)){
                
                echo '<a class="box" href="watch-video.php?ispremium='.$isPremium .'&video_id=' . $fetch_video["id"] .'" id="video-link" data-video-id="' . $fetch_video["id"] . '">


              <i class="fas fa-play"></i>
              <img src="uploaded_files/' . $fetch_video["thumb"] . '" alt="" style="height: 30rem;">
              <h3>' . $fetch_video['title'] . '</h3>
          </a>';
                
            }
            ?>

        </div>

    </section>

    <?php include "./components/footer.php"; ?>

    <!-- Custom JS -->
    <script src="js/script.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the video link element
    var videoLink = document.getElementById("video-link");
    
    // Add click event listener to the video link
    videoLink.addEventListener("click", function(event) {
        // Prevent the default link behavior (i.e., following the href)
        event.preventDefault();
        
        // Check if the user is logged in (you may need to adjust this condition)
        <?php if(isset($_SESSION['user_id'])) { ?>
            // User is logged in, redirect to the watch page
            window.location.href = videoLink.getAttribute("href");
        <?php } else { ?>
            // User is not logged in, redirect to the login page
            window.location.href = "login.php";
        <?php } ?>
    });
});
</script>

</body>

</html>