<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin.</a>

      <form action="search_page.php" method="post" class="search-form">
         <input type="text" name="search" placeholder="search here..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = "SELECT * FROM `tutors` WHERE id = '$tutor_id'";
            $profile_result = mysqli_query($conn, $select_profile);
            $profile_count = mysqli_num_rows($profile_result);
            if($profile_count > 0){
            $profile_row = mysqli_fetch_assoc($profile_result);
         ?>
         <img src="../uploaded_files/<?= $profile_row['image']; ?>" alt="">
         <h3><?= $profile_row['name']; ?></h3>
         <span><?= $profile_row['profession']; ?></span>
         <a href="profile.php" class="btn">view profile</a>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = "SELECT * FROM `tutors` WHERE id = '$tutor_id'";
            $profile_result = mysqli_query($conn, $select_profile);
            $profile_count = mysqli_num_rows($profile_result);
            if($profile_count > 0){
            $profile_row = mysqli_fetch_assoc($profile_result);
         ?>
         <img src="../uploaded_files/<?= $profile_row['image']; ?>" alt="">
         <h3><?= $profile_row['name']; ?></h3>
         <span><?= $profile_row['profession']; ?></span>
         <a href="profile.php" class="btn">view profile</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="playlists.php"><i class="fa-solid fa-bars-staggered"></i><span>playlists</span></a>
      <a href="contents.php"><i class="fas fa-graduation-cap"></i><span>contents</span></a>
      <a href="comments.php"><i class="fas fa-comment"></i><span>comments</span></a>
      <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>
   </nav>

</div>

<!-- side bar section ends -->