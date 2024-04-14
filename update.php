



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
    // require "./components/dbconnect.php";
    $id = $_GET['userid'];
    
    if ($_SERVER["REQUEST_METHOD"] == 'POST'){

        $query = "select * from users where id = '$id' ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);


        $image = $row['image'];
        $image = $_FILES['image']['name'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_files/' . $rename;

        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['c_pass'];

        if(!empty($_POST['name'])){
            $name = $_POST['name'];
            $query = "UPDATE users SET name = '$name' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
        }

        if(!empty($_POST['email'])){
            $email = $_POST['email'];
            $query = "UPDATE users SET email = '$email' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
        }

        if(!empty($_POST['old_pass'])){
            if($old_pass !=  $row['password']){
                $message[] = 'Old password not matched';
            }else{
                if($new_pass != $confirm_pass){
                    $message[] = 'New password not matched with Confirm Password!';
                }else{
                    $query = "UPDATE users SET password = '$new_pass' WHERE id = '$id'";
                    $result = mysqli_query($conn, $query);
                }
            }
        }

        if(!empty( $image)){
            $query = "UPDATE users SET image = '$rename' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            move_uploaded_file($image_tmp_name, $image_folder);
        }


      
    }
?>

<?php
// Display error/success messages
if (!empty($message)) {
    foreach($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>update profile</h3>
      <p>update name</p>
      <input type="text" name="name" placeholder="<?= $name ?>" maxlength="50" class="box">
      <p>update email</p>
      <input type="email" name="email" placeholder="<?= $email ?>" maxlength="50" class="box">
      <p>previous password</p>
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20" class="box">
      <p>new password</p>
      <input type="password" name="new_pass" placeholder="enter your old password" maxlength="20" class="box">
      <p>confirm password</p>
      <input type="password" name="c_pass" placeholder="confirm your new password" maxlength="20" class="box">
      <p>update pic</p>
      <input type="file" name="image" accept="image/*"  class="box">
      <input type="submit" value="update profile" name="submit" class="btn">
   </form>

</section>


<?php include "./components/footer.php" ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>