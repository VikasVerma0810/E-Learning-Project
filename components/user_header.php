
<?php
   session_start();
   require "./components/dbconnect.php";

?>
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

      <a href="index.html" class="logo">E-LEARN</a>

      <form action="search_course.php" method="post" class="search-form">
         <input type="text" name="search_course" placeholder="search courses..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

   <?php

      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
         $id = $_SESSION['user_id'];
         $query = "SELECT * FROM users WHERE id = '$id'";
         $result = mysqli_query($conn, $query);
         $row = mysqli_fetch_assoc($result);
         $name = $row["name"];
         $email = $row["email"];
         $imageUrl = $row["image"];
         echo '
            <div class="profile">
               <img src="uploaded_files/'.$imageUrl.'" class="image" alt="">
               <h3 class="name">'.$name.'</h3>
               <p class="role">student</p>
               <a href="profile.php?userid='.$id.'&username='.$name.'" class="btn">view profile</a>
               <div class="flex-btn">
                  <a href="progress.php" class="option-btn">Progress</a>
                  <a href="logout.php" class="option-btn">Log out</a>
               </div>
            </div>';
      }else{
         echo '
         <div class="profile">
            <div class="flex-btn">
               <a href="login.php" class="option-btn">Login</a>
               <a href="register.php" class="option-btn">Register</a>
            </div>
         </div>';
      }
   ?>

   </section>

</header>   

<div class="side-bar">

   <div id="close-btn">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      <?php
         
         if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            // require "./components/dbconnect.php";
            $id = $_SESSION['user_id'];
            $query = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            $row2 = mysqli_fetch_assoc($result);
            $name = $row2["name"];
            $email = $row2["email"];
            $imageUrl = $row2["image"];
            $premium = $row2["premium"];
            echo '<img src="uploaded_files/'.$imageUrl.'" alt="">';
                  if($premium==1){
                     echo '<h3 class="name">'. $name .'<i class="fa-solid fa-crown" style="color:#FFD700"></i></h3>';
                  }
                 
                  echo '<p class="role">student</p>
                  <a href="profile.php?userid='.$id.'&username='.$name.'" class="btn">view profile</a>
                  ';
                  if($premium!=1){
                     echo '<a href="premium.php" class="btn" style="color:#FFD700"> <i class="fa-solid fa-crown"></i>Primum</a>';
                  }
                 
         }else{
            echo '<h1>please login or register</h1>
                  <div class="flex-btn" style="padding-top: .5rem;">
                     <a href="login.php" class="option-btn">login</a>
                     <a href="register.php" class="option-btn">register</a>
                  </div>
                  <a href="premium.php" class="btn" style="color:#FFD700"> <i class="fa-solid fa-crown"></i>Primum</a>';
         } 
      ?>

      
   </div>

   <nav class="navbar">
      <?php 
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
         $id =  $_SESSION['user_id'];
         echo '<a href="home.php?userid='.$id.'"><i class="fas fa-home"></i><span>home</span></a>
               <a href="about.php?userid='.$id.'"><i class="fas fa-question"></i><span>about</span></a>
               <a href="courses.php?userid='.$id.'"><i class="fas fa-graduation-cap"></i><span>courses</span></a>';
      }else{
         echo '<a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
               <a href="about.php"><i class="fas fa-question"></i><span>about</span></a>
               <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>';
      }
      ?>
      
      <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
      <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
   </nav>

</div>