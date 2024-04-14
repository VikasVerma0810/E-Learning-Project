<?php

include '../components/dbconnect.php';
   if ($_SERVER["REQUEST_METHOD"] == 'POST') {
      $email = $_POST['email'];
      $password  = $_POST['password'];

      $query = "SELECT * FROM tutors WHERE email = '$email'";
      $result = mysqli_query($conn, $query);
      $count = mysqli_num_rows($result);
      

      if($count >= 1){
      
         $row = mysqli_fetch_assoc($result);

         if($password ==  $row['password'])
         {
            setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
            header("location:dashboard.php?tutor_id=".$id);
            exit;
         }else{
            $message[] = 'Wrong Username or Password. Please try again.';
         }
      }else{
         $message[] = 'Wrong Username or Password. Please try again.';
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="padding-left: 0;">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- register section starts  -->

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>welcome back!</h3>
      <p>your email <span>*</span></p>
      <input type="email" name="email" placeholder="enter your email" maxlength="20" required class="box">
      <p>your password <span>*</span></p>
      <input type="password" name="password" placeholder="enter your password" maxlength="20" required class="box">
      <p class="link">don't have an account? <a href="register.php">register new</a></p>
      <input type="submit" name="submit" value="login now" class="btn">
   </form>

</section>

<!-- registe section ends -->














<script>

let darkMode = localStorage.getItem('dark-mode');
let body = document.body;

const enabelDarkMode = () =>{
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}else{
   disableDarkMode();
}

</script>
   
</body>
</html>