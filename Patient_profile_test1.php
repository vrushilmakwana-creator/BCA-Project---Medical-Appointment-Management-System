<?php 
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$email = $_SESSION["email"]; // Get logged-in user's email

// Database configuration
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "medconnect";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patient details
$sql = "SELECT PfirstName, PmiddleName, PlastName, Page, Gender, Pstate, Pdob, email, PAddress, Pcity, Ppincode, PProfilePic FROM pprofile WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$patientData = $result->fetch_assoc();

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            margin-top: 5px;
        }
        .profile-photo {
            display: block;
            margin: 10px auto;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <center><h1><b>Patient Profile</b></h1></center>

    <!-- Profile Picture -->
    <?php if (!empty($patientData['PProfilePic'])): ?>
        <img src="<?php echo htmlspecialchars($patientData['PProfilePic']); ?>" alt="Profile Picture" class="profile-photo">
    <?php endif; ?>

    <form method="POST">
        <label>First Name:</label>
        <input type="text" name="PfirstName" value="<?php echo htmlspecialchars($patientData['PfirstName'] ?? ''); ?>" readonly>

        <label>Middle Name:</label>
        <input type="text" name="PmiddleName" value="<?php echo htmlspecialchars($patientData['PmiddleName'] ?? ''); ?>" readonly>

        <label>Last Name:</label>
        <input type="text" name="PlastName" value="<?php echo htmlspecialchars($patientData['PlastName'] ?? ''); ?>" readonly>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($patientData['email'] ?? ''); ?>" readonly>

        <label>Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($patientData['Page'] ?? ''); ?>" readonly>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($patientData['Pdob'] ?? ''); ?>" readonly>

        <label>Gender:</label>
        <input type="text" name="gender" value="<?php echo htmlspecialchars($patientData['Gender'] ?? ''); ?>" readonly>

        <label>Address:</label>
        <textarea name="address" readonly><?php echo htmlspecialchars($patientData['PAddress'] ?? ''); ?></textarea>

        <label>City:</label>
        <input type="text" name="city" value="<?php echo htmlspecialchars($patientData['Pcity'] ?? ''); ?>" readonly>

        <label>State:</label>
        <input type="text" name="state" value="<?php echo htmlspecialchars($patientData['Pstate'] ?? ''); ?>" readonly>

        <label>Pin Code:</label>
        <input type="text" name="pinCode" value="<?php echo htmlspecialchars($patientData['Ppincode'] ?? ''); ?>" readonly>

    </form>
</div>

</body>
</html>