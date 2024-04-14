<?php

   include '../components/dbconnect.php';

   if(isset($_COOKIE['tutor_id'])){
      $tutor_id = $_COOKIE['tutor_id'];
   }else{
      $tutor_id = '';
      header('location:login.php');
   }

if(isset($_POST['submit'])){

   $select_tutor = "SELECT * FROM `tutors` WHERE id = '$tutor_id' LIMIT 1";
   $select_tutor_result = mysqli_query($conn,$select_tutor);
   $fetch_tutor = mysqli_fetch_assoc($select_tutor_result);
   $prev_pass = $fetch_tutor['password'];
   $prev_image = $fetch_tutor['image'];

   $name = $_POST['name'];
   $profession = $_POST['profession'];
   $email = $_POST['email'];

   if(!empty($name)){
      $update_name = "UPDATE `tutors` SET name = '$name' WHERE id = ' $tutor_id'";
      $update_name_result = mysqli_query($conn,$update_name);
      $message[] = 'username updated successfully!';
   }

   if(!empty($profession)){
      $update_profession = "UPDATE `tutors` SET profession = '$profession' WHERE id = '$tutor_id'";
      $update_profession_result = mysqli_query($conn,$update_profession);
      $message[] = 'profession updated successfully!';
   }

   if(!empty($email)){
      $select_email = "SELECT email FROM `tutors` WHERE id = '$tutor_id' AND email = ' $email'";
      $select_email_result = mysqli_query($conn,$select_email);
      if(mysqli_num_rows($select_email_result) > 0){
         $message[] = 'email already taken!';
      }else{
         $update_email = "UPDATE `tutors` SET email = '$email' WHERE id = '$tutor_id'";
         mysqli_query($conn,$update_email);
         $message[] = 'email updated successfully!';
      }
   }

   $image = $_FILES['image']['name'];
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size too large!';
      }else{
         $update_image = "UPDATE `tutors` SET `image` = '$rename' WHERE id = ' $tutor_id'";
         mysqli_query($conn,$update_image);
         move_uploaded_file($image_tmp_name, $image_folder);
         if($prev_image != '' AND $prev_image != $rename){
            unlink('../uploaded_files/'.$prev_image);
         }
         $message[] = 'image updated successfully!';
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $cpass = $_POST['cpass'];

   if($old_pass!=''){
      if($old_pass != $prev_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $update_pass = "UPDATE `tutors` SET password = '$cpass' WHERE id = '$tutor_id'";
         mysqli_query($conn,$update_pass);
         $message[] = 'password updated successfully!';
      }
   }
      
   

}

   $select_tutor = "SELECT * FROM `tutors` WHERE id = '$tutor_id' LIMIT 1";
   $select_tutor_result = mysqli_query($conn,$select_tutor);
   $fetch_profile = mysqli_fetch_assoc($select_tutor_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<?php include '../components/admin_header.php'; ?>

<!-- register section starts  -->

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>update profile</h3>
      <div class="flex">
         <div class="col">
            <p>your name </p>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50"  class="box">
            <p>your profession </p>
            <select name="profession" class="box">
               <option value="" selected><?= $fetch_profile['profession']; ?></option>
               <option value="developer">developer</option>
               <option value="desginer">desginer</option>
               <option value="musician">musician</option>
               <option value="biologist">biologist</option>
               <option value="teacher">teacher</option>
               <option value="engineer">engineer</option>
               <option value="lawyer">lawyer</option>
               <option value="accountant">accountant</option>
               <option value="doctor">doctor</option>
               <option value="journalist">journalist</option>
               <option value="photographer">photographer</option>
            </select>
            <p>your email </p>
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="20"  class="box">
         </div>
         <div class="col">
            <p>old password :</p>
            <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box">
            <p>new password :</p>
            <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box">
            <p>confirm password :</p>
            <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20"  class="box">
         </div>
      </div>
      <p>update pic :</p>
      <input type="file" name="image" accept="image/*"  class="box">
      <input type="submit" name="submit" value="update now" class="btn">
   </form>

</section>

<!-- registe section ends -->










<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>
   
</body>
</html>