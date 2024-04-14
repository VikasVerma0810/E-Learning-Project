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
        
        openModal('$19/month');
      };

      yearlyBtn.onclick = function() {
        openModal('$199/year');
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

      // Submit event listener for the payment form (optional)
      paymentForm.addEventListener('submit', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Implement your payment processing logic here
      });
    });
