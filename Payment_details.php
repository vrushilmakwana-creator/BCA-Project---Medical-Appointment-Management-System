<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "medconnect");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted and required parameters are in URL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['request_id']) && isset($_GET['patient_email'])) {
    
    // Retrieve request_id and patient_email from URL
    $request_id = $_GET['request_id'];
    $patient_email = $_GET['patient_email'];

    // Get the logged-in doctor's email from session
    if (isset($_SESSION['email'])) {
        $doctor_email = $_SESSION['email'];
    } else {
        die("Session expired. Please log in again.");
    }

    // Fetch doctor's details and fees
    $query = "SELECT DfirstName, DlastName, clinic, Dfees FROM dprofile WHERE email = '$doctor_email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $doctor_name = $row['DfirstName'] . " " . $row['DlastName'];
        $clinic = $row['clinic'];
        $fees = $row['fees'];
    } else {
        die("Doctor details not found.");
    }

    // Get payment details from form
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    // Insert into payment table
    $insert_query = "INSERT INTO payment (request_id, patient_email, doctor_email, amount, card_number, expiry, cvv, payment_status)
                     VALUES ('$request_id', '$patient_email', '$doctor_email', '$fees', '$card_number', '$expiry', '$cvv', 'Completed')";
    
    if ($conn->query($insert_query) === TRUE) {
        echo "Payment successful!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 25px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            border-top: 5px solid #007bff; /* Blue top border */
        }
        h2 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .details {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .details strong {
            color: #0056b3;
        }
        .input-field {
            width: 94%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            flex: 1;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin: 0 5px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
        }
        .btn-cancel:hover {
            background: #a71d2a;
        }
        /* Popup Styles */
        .popup-overlay, .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }
        .popup-box, .loading-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .popup-btn {
            margin: 10px;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .popup-btn-yes {
            background: #007bff;
            color: white;
        }
        .popup-btn-no {
            background: #dc3545;
            color: white;
        }
        /* Loading Animation */
        .loading-box img {
            width: 50px;
            margin-bottom: 10px;
        }
        /* Payment Success Message */
        .success-message {
            display: none;
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
        }
        .btn-btn-primary {
            display: none; /* Hide OK button initially */
            margin-top: 20px;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-btn-primary:hover {
            background-color: #0056b3;
        }
        @keyframes dots {
            0% { content: "Processing"; }
            33% { content: "Processing."; }
            66% { content: "Processing.."; }
            100% { content: "Processing..."; }
        }

        .processing-text::after {
            content: "Processing";
            animation: dots 1s infinite steps(1);
            display: inline-block;
        }
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .loading-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .processing-text::after {
            content: "Processing";
            animation: dots 1s infinite steps(1);
            display: inline-block;
        }



    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let expiryInput = document.getElementById("expiry");

            expiryInput.addEventListener("input", function (e) {
                let value = e.target.value.replace(/\D/g, ""); // Remove non-numeric characters
                if (value.length > 2) {
                    value = value.substring(0, 2) + "/" + value.substring(2, 4);
                }
                e.target.value = value;
            });
        });

        function showPopup(action) {
            let form = document.getElementById("paymentForm");

            // Check if form is valid before showing popup
            if (!form.checkValidity()) {
                alert("Please fill in all the required fields.");
                return false;
            }

            document.getElementById("popupText").innerText = 
                action === 'proceed' ? "Are you sure you want to proceed with payment?" 
                                     : "Are you sure you want to cancel the payment?";

            document.getElementById("popupConfirm").onclick = function() {
                if (action === 'proceed') {
                    // Hide the popup and show the loading animation
                    document.getElementById("popupOverlay").style.display = "none";
                    document.getElementById("loadingOverlay").style.display = "flex";

                    // Start processing after delay
                    setTimeout(processPayment, 3000);
                } else {
                    window.location.href = "dashboard.php";
                }
            };

            document.getElementById("popupOverlay").style.display = "flex";
            return false;
        }



        function closePopup() {
            document.getElementById("popupOverlay").style.display = "none";
        }

        function processPayment() {
            closePopup();
            document.getElementById("loadingOverlay").style.display = "flex";

            // Show processing text
            document.getElementById("processingText").style.display = "block";

            setTimeout(() => {
                document.getElementById("loadingOverlay").style.display = "none";
                document.getElementById("processingText").style.display = "none"; // Hide after animation
                document.getElementById("paymentForm").style.display = "none"; // Hide form
                document.getElementById("successMessage").style.display = "block"; // Show success message
                document.querySelector(".btn-btn-primary").style.display = "block"; // Show OK button
            }, 3000);  // Simulating a 3-second payment process
        }

        function redirectHome(){
            window.location.href="patient_home.php";
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Payment</h2>

    <div class="details">
        <strong>Doctor:</strong> Dr. <?= htmlspecialchars($appointment['DfirstName'] . ' ' . $appointment['DlastName']); ?><br>
        <strong>Clinic:</strong> <?= htmlspecialchars($appointment['clinic']); ?><br>
        <strong>Appointment ID:</strong> <?= htmlspecialchars($appointment['request_id']); ?><br>
        <strong>Amount:</strong> ₹2600
    </div>

    <!-- Payment Form -->
    <form id="paymentForm" method="POST" onsubmit="return showPopup('proceed')">
        <input type="hidden" name="request_id" value="<?= htmlspecialchars($appointment['request_id']); ?>">
        <input type="hidden" name="amount" value="2600">
        <input type="hidden" name="patient_email" value="<?= htmlspecialchars($patient_email); ?>">
        <input type="hidden" name="doctor_email" value="<?= htmlspecialchars($appointment['doctor_email']); ?>">

        <input type="text" class="input-field" name="card_number" placeholder="Card Number" required>
        <input type="text" class="input-field" name="card_holder" placeholder="Cardholder Name" required>
        <input type="text" class="input-field" name="expiry" id="expiry" placeholder="MM/YY" maxlength="5" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" required>
        <input type="password" class="input-field" name="cvv" placeholder="CVV (4 Digits)" pattern="\d{4}" maxlength="4" required>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Confirm Payment</button>
            <button type="button" class="btn btn-cancel" onclick="showPopup('cancel')">Cancel</button>
        </div>
    </form>

    <!-- Payment Success Message -->
    <p class="success-message" id="successMessage" style="display:none;">✅ Payment Successful! Your appointment is confirmed.</p>
    <center><button onclick="redirectHome()" class="btn-btn-primary" style="display:none;">OK</button></center>
</div>

<!-- Popup -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <p id="popupText"></p>
        <button class="popup-btn popup-btn-yes" id="popupConfirm">Yes</button>
        <button class="popup-btn popup-btn-no" onclick="closePopup()">No</button>
    </div>
</div>
<!-- Loading Animation -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-box"> <!-- Use your own loading GIF -->
        <p id="processingText" class="processing-text"></p>
    </div>
</div>


</body>
</html>
