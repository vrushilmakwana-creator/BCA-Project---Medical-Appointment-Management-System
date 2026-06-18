<?php
// Sample data (Fetch from database in real implementation)
$appointment_id = 12345;
$doctor_name = "Dr. Erwin Smith";
$amount = 2600; // Amount in INR
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
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
            color: #007bff; /* Matching blue */
            margin-bottom: 15px;
        }
        .details {
            background: #e3f2fd; /* Light blue box */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .details strong {
            color: #0056b3; /* Darker blue for labels */
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
    </style>
</head>
<body>

<div class="container">
    <h2>Request Accepted</h2>
    <div class="details">
        <strong>Doctor:         </strong> <?php echo $doctor_name; ?><br>
        <strong>Appointment ID: </strong> <?php echo $appointment_id; ?><br>
        <strong>Amount:         </strong> ₹<?php echo $amount; ?>
    </div>

    <!-- Buttons: Proceed to Payment & Cancel -->
    <div class="btn-container">
        <form action="Payment_details.php" method="POST">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
<br><br>
        <form action="patient_home.php" method="GET">
            <button type="submit" class="btn btn-cancel">Cancel</button>
        </form>
    </div>
</div>

</body>
</html>