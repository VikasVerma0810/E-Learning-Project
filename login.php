


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

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

<!-- handling form  -->
<?php 

    $message = [];

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $email = $_POST['email'];
        $password  = $_POST['password'];

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        

        if($count >= 1){
          
            $row = mysqli_fetch_assoc($result);

            if($password ==  $row['password'])
            {
                echo $email;
                session_start();
                $id = $row['id'];
                $_SESSION['loggedin'] = true;
                $_SESSION['username']=$username;
                $_SESSION['user_id']=$id;
                // echo "login";
                header("location:home.php?userid=".$id);
                exit;
            }else{
                $message[] = 'Wrong Username or Password. Please try again.';
            }
        }else{
            $message[] = 'no ';
        }
    }

?>

<section class="form-container">

<form action="" method="POST" enctype="multipart/form-data">
   <h3>login now</h3>
   <p>your email <span>*</span></p>
   <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
   <p>your password <span>*</span></p>
   <input type="password" name="password" placeholder="enter your password" required maxlength="20" class="box">
   <input type="submit" value="login" class="btn">
</form>

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