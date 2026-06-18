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
            margin: 0; 
            padding: 0; 
            line-height: 1.5; 
        } 
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        header .search {
            flex-grow: 1;
            margin: 0 20px;
        }
        header .search input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: px;
        }
        nav {
            display: flex;
            justify-content: center;
            background: #333;
            color: #fff;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            padding: 5px 10px;
        }
        nav a:hover {
            background: #555;
            border-radius: 4px;
        }
        footer {
            padding: 10px 20px;
            background: #f5f5f5;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }
        footer a {
            margin-right: 15px;
            color: #333;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .logo{
              max-width: 160px;
              height: auto;
              display: block;
              margin: 10px;
        }
        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        } 
        /* Center the Profile Card */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        /* Patient Profile Card */
        .profile-card {
            display: flex;
            width: 650px;
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .left-section {
            width: 40%;
            background: #cce7ff;
            text-align: center;
            padding: 20px;
        }
        .left-section img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid white;
        }
        .left-section h2 {
            margin-top: 10px;
            font-size: 20px;
            color: #003366;
        }
        .left-section p {
            font-size: 14px;
            color: #444;
        }

        .right-section {
            width: 60%;
            padding: 20px;
        }
        h3 {
            margin-bottom: 5px;
            color: #003366;
            font-size: 16px;
        }
        p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .details {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        .details span {
            display: inline-block;
            background: #d9f0ff;
            padding: 5px 10px;
            margin: 3px;
            border-radius: 5px;
            font-size: 13px;
            color: #003366;
        }
        .history, .appointments {
            margin-top: 15px;
            padding: 10px;
            background: #f5faff;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .history h3, .appointments h3 {
            margin-bottom: 5px;
            color: #003366;
            font-size: 15px;
        }
        .history p, .appointments p {
            font-size: 14px;
            color: #555;
        }
        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
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
        .none-link{
            text-decoration: none;
            color: inherit;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        header .search {
            flex-grow: 1;
            margin: 0 20px;
        }
        header .search input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: px;
        }
        nav {
            display: flex;
            justify-content: center;
            background: #333;
            color: #fff;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            padding: 5px 10px;
        }
        nav a:hover {
            background: #555;
            border-radius: 4px;
        }
        footer {
            padding: 10px 20px;
            background: #f5f5f5;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }
        footer a {
            margin-right: 15px;
            color: #333;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .logo{
              max-width: 160px;
              height: auto;
              display: block;
              margin: 10px;
        }
        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
            background-color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <img src="Official_LOGO_MedicalAppointmwntManagement.png" alt="logo" class="logo">
        <div class="search">
            <input type="text" placeholder="Search...">
        </div>
        <div class="icons">
            <span>🔍</span>
            <span>💬</span>
        </div>
    </header>
    <nav>
        <a href="patient_home.php">Home</a>
        <a href="Appointment_page.php">Appointment</a>
        <a href="Quiz_232.php">Quiz</a>
        <a href="Patient_profile.php">Profile</a>
    </nav>
<main>
    <div class="profile-card">
        <!-- Left Section (Profile Picture & Name) -->
        <div class="left-section">
            <?php if (!empty($patientData['PProfilePic'])): ?>
                <img src="<?php echo htmlspecialchars($patientData['PProfilePic']); ?>" alt="Profile Picture">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($patientData['PfirstName'] . " " . $patientData['PlastName']); ?></h2>
            <p><?php echo htmlspecialchars($patientData['email']); ?></p>
        </div>

        <!-- Right Section (Details) -->
        <div class="right-section">
            <h3>Personal Details</h3>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($patientData['Page']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($patientData['Pdob']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($patientData['Gender']); ?></p>

            <h3>Address</h3>
            <p><?php echo htmlspecialchars($patientData['PAddress'] . ", " . $patientData['Pcity'] . ", " . $patientData['Pstate'] . " - " . $patientData['Ppincode']); ?></p>
            <a href="Patient_profile_management.php"><input type="submit" value="Edit profile"></a>
        </div>
    </div>
</main>
<footer>
        <div>
            <a href="Help_232.php">Help</a>
            <a href="Privacy_policy_232.php">Privacy Policy</a>
            <a href="Contact_us.php">Contact Us</a>
            <a href="">Documentation</a>
            <a href="About_us.php">About Us</a>
            <a href="FAQ_232.php">FAQ</a>
        </div>
        <div>IG : vrushilmakwana</div>
    </footer>
</body>
</html>