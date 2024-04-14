
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "./components/user_header.php"; ?>

<!-- handling form  -->
<?php

    $message = []; // Array to store error/success messages

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password  = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // File upload handling
        if (isset($_FILES['image'])) {
            $image = $_FILES['image']['name'];
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = unique_id() . '.' . $ext;
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = 'uploaded_files/' . $rename;
        } else {
            $message[] = 'Image file is required.';
        }

        // Check if email is already registered
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $message[] = 'Email already taken!';
        } else {
            if ($password != $cpassword) {
                $message[] = 'Confirm password not matched!';
            } else {
                // Insert user data into database
                $query = "INSERT INTO users (name, email, password, image) VALUES ('$name', '$email', '$password', '$rename')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    // Move uploaded image to folder
                    move_uploaded_file($image_tmp_name, $image_folder);
                    
                    header('location: login.php');
                    exit;
                } else {
                    $message[] = 'Error inserting data into database.';
                }
            }
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
      <h3>Register Now</h3>
      <p>Your Name <span>*</span></p>
      <input type="text" name="name" placeholder="Enter your name" required maxlength="50" class="box">
      <p>Your Email <span>*</span></p>
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <p>Your Password <span>*</span></p>
      <input type="password" name="password" placeholder="Enter your password" required maxlength="20" class="box">
      <p>Confirm Password <span>*</span></p>
      <input type="password" name="cpassword" placeholder="Confirm your password" required maxlength="20" class="box">
      <p>Select Profile Image <span>*</span></p>
      <input type="file" name="image" accept="image/*" required class="box">
      <input type="submit" value="Register" class="btn">
   </form>
</section>

<?php include "./components/footer.php"; ?>

<!-- Custom JS -->
<script src="js/script.js"></script>

</body>
</html>
