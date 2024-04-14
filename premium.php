<?php
   session_start();
   require "./components/dbconnect.php";

   if(isset($_POST['submit'])){
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $user_id = $_SESSION['user_id'];

    // Validate card number
    if ($cardNumber  < 13 ) {
        $_SESSION['card_error'] = "Invalid card number.";
  
    }

    // Validate expiry date
    $currentYear = date("Y");
    $currentMonth = date("m");
    $expiryDateParts = explode("/", $expiryDate);
    if (count($expiryDateParts) >= 2) { // Check if the array has at least 2 elements
        $expiryYear = intval($expiryDateParts[1]);
        $expiryMonth = intval($expiryDateParts[0]);
        if ($expiryYear < $currentYear || ($expiryYear == $currentYear && $expiryMonth < $currentMonth)) {
            $_SESSION['date_error'] = "Expiry date must be in the future.";
        }
    } else {
        $_SESSION['date_error'] = "Invalid expiry date format."; // Handle invalid date format
    }

    // Insert the form data into the database
    $query = "INSERT INTO payment (user_id, card_no) VALUES ('$user_id', '$cardNumber')";
    $reult = mysqli_query($conn, $query);

    // Execute the statement
    if ($reult) {
      $isPrem = 1;
      $query2 = "  UPDATE `users` SET `premium` = '1' WHERE `users`.`id` = '$user_id'";
      $reult2 = mysqli_query($conn, $query2);
        // Payment details saved successfully
        $_SESSION['success'] = "Payment details saved successfully.";
        header("location:home.php?userid=".$user_id);
    } else {
        // Error occurred while saving payment details
        echo "Error: " . $conn->error;
    }

    // Close the statement and database connection

   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/premium.css">
    <link rel="stylesheet" href="./css/paymentModal.css">

    <style>
      .alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    margin-bottom: 15px;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}

    </style>
</head>
<body>

    <?php
   
    // if (isset($_SESSION['error'])) {
    //     echo $_SESSION['error'];
    //     unset($_SESSION['error']);
    // }

    
    ?>

<?php
    // Display error message if present
    if (isset($_SESSION['card_error'])) {
?>
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $_SESSION['card_error']; ?>
        </div>
<?php
        unset($_SESSION['card_error']);
    }
?>

<?php
    // Display error message if present
    if (isset($_SESSION['date_error'])) {
?>
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $_SESSION['date_error']; ?>
        </div>
<?php
        unset($_SESSION['date_error']);
    }
?>

    
  <div class="centered-button" >
    <button> <a href="./home.php">Back to Home page</a> 
    </a></button>
  </div>
  
  <h1>Choose the plan that fits for you</h1> <br><br>
     
      
      <div class="pricing">
        <!-- Monthly Plan -->
        <div class="plan popular">
          <h2>Monthly</h2>
          <div class="price">$19/month</div>
          <ul class="features">
            <li><i class="fas fa-check-circle"></i> Unlimited Courses</li>
            <li><i class="fas fa-check-circle"></i> Unlimited Students</li>
            <li><i class="fas fa-check-circle"></i> Continuous updates</li>
          </ul>
          <button id="getMonthlyPlan">Get it</button>
        </div>
        <!-- Yearly Plan -->
        <div class="plan popular">
          <span>Most Popular</span>
          <h2>Yearly</h2>
          <div class="price">$199/year</div>
          <ul class="features">
            <li><i class="fas fa-check-circle"></i> Unlimited Courses</li>
            <li><i class="fas fa-check-circle"></i> Unlimited Students</li>
            <li><i class="fas fa-check-circle"></i> Continuous updates</li>
          </ul>
          <button id="getYearlyPlan">Get it</button>
        </div>
      </div>

    <header>
        <h2>Which Version Is Right for You?</h2>
      </header>
      <!-- Comparison Table -->
      <div class="wrapper">
        <div class="table">
          <!-- Column Icons -->
          <div class="flex-row">
            <div class="flex-cell t-col borderless empty"></div>
            <div class="flex-cell t-col borderless">
              <img class="icon light" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col borderless">
              <img class="icon pro" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>
          <!-- Column Names -->
          <div class="flex-row">
            <div class="flex-cell t-col borderless empty"></div>
            <div class="flex-cell t-col borderless title">
              Free
            </div>
            <div class="flex-cell t-col borderless title">
              Paid
            </div>
          </div>
          <!-- Feature Rows -->
          <div class="flex-row">
            <div class="flex-cell t-col feature">
              <p><b>Access to Premium Courses</b><br/>
                Explore exclusive premium courses.</p>
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Limited</span>
              <img class="icon cross" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Full Access</span>
              <img class="icon check" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>
          <div class="flex-row">
            <div class="flex-cell t-col feature">
              <p><b>Ad-Free Experience</b><br/>
                Learn without distractions.</p>
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">No</span>
              <img class="icon cross" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Yes</span>
              <img class="icon check" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>
          <div class="flex-row">
            <div class="flex-cell t-col feature">
              <p><b>Live Q&A Sessions</b><br/>
                Participate in live question and answer sessions with instructors.</p>
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">No</span>
              <img class="icon cross" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Yes</span>
              <img class="icon check" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>
          <div class="flex-row">
            <div class="flex-cell t-col feature">
              <p><b>Downloadable Resources</b><br/>
                Access downloadable materials such as PDFs and exercise files.</p>
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Limited</span>
              <img class="icon cross" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Unlimited</span>
              <img class="icon check" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>
          <div class="flex-row">
            <div class="flex-cell t-col feature">
              <p><b>Course Completion Certificates</b><br/>
                Receive certificates upon completing courses.</p>
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">No</span>
              <img class="icon cross" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Yes</span>
              <img class="icon check" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>
          <div class="flex-row">
            <div class="flex-cell t-col feature">
              <p><b>Priority Customer Support</b><br/>
                Get faster response times and priority assistance.</p>
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">No</span>
              <img class="icon cross" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
            <div class="flex-cell t-col">
              <span class="alt-txt">Yes</span>
              <img class="icon check" src="https://github.com/WilliamWorkman/demos/blob/master/images/img.gif?raw=true">
            </div>
          </div>

        </div>
      </div>
        
      
   <!-- Modal -->
   <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 style="text-align: center;">Payment Details</h2>
      <p>Amount to be paid: <span class="payment-amount"></span></p>
      <form class="payment-form" action="" method="post">
        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter your card number" required>

        <label for="expiryDate">Expiry Date:</label>
        <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YYYY" required>

        <label for="cvv">CVV:</label>
        <input type="number" id="cvv" name="cvv" placeholder="Enter CVV" required>

        <input type="submit" name="submit" value="Pay Now">
      </form>
    </div>
  </div>

  <footer>
        <div class="footer-content">
          <p>Contact us: info@example.com</p>
          <p>Follow us on <a href="#">Twitter</a> and <a href="#">Facebook</a></p>
        </div>
    </footer>
  

  <!-- <script src="./js/modal_script.js"></script> -->
  <script>
        document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById("myModal");
  var monthlyBtn = document.getElementById("getMonthlyPlan");
  var yearlyBtn = document.getElementById("getYearlyPlan");
  var closeBtn = document.getElementsByClassName("close")[0];
  var paymentForm = document.querySelector('.payment-form');
  var paymentAmount = document.querySelector('.payment-amount');

  // Function to open the modal and set the payment amount
  function openModal(amount) {
    modal.style.display = "block";
    paymentAmount.textContent = amount;
  }

  // Function to close the modal
  function closeModal() {
    modal.style.display = "none";
  }

  // Event listeners to open the modal when clicking the buttons
  monthlyBtn.onclick = function() {
    checkLogin('$19/month');
  };

  yearlyBtn.onclick = function() {
    checkLogin('$199/year');
  };

  // Event listener to close the modal when clicking the close button
  closeBtn.onclick = closeModal;

  // Event listener to close the modal when clicking outside of it
  window.onclick = function(event) {
    if (event.target == modal) {
      closeModal();
    }
  }

  // Event listener to close the modal when pressing the escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
      closeModal();
    }
  });

  

  // Function to check login status and redirect if not logged in
  function checkLogin(amount) {
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
      openModal(amount);
    <?php else: ?>
      window.location.href = 'login.php';
    <?php endif; ?>
  }
  
});

  </Script>
</body>
</html>