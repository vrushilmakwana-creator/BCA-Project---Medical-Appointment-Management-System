
    
<?php
session_start();

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medconnect";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    die("Access Denied. Please log in.");
}

// Fetch the email from URL parameter
if (!isset($_GET['email']) || empty($_GET['email'])) {
    die("No doctor profile selected.");
}

$final_found_email = $_GET['email']; // Store the email in a variable

// Fetch doctor profile details
$stmt = $conn->prepare("SELECT DfirstName, DmiddleName, DlastName, mobileNo, Qualification, Dage, Dgender, Dstate, Ddob, email, clinic, Dcity, Dpincode, DProfilePic, Specialization, Expyear, start_time, end_time, Dfees FROM dprofile WHERE email = ?");
$stmt->bind_param("s", $final_found_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
} else {
    die("Doctor profile not found.");
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <!-- Add your styles here -->
    <style>
        &{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial,sans-serif;
        }
                /* Center the Profile Card */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        /* Doctor Profile Card */
        .profile-card {
            display: flex;
            width: 880px; /* Increased by 35% */
            background: white;
            border-radius: 15px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* Left Section - Doctor's Image & Info */
        .left-section {
            width: 40%;
            background: linear-gradient(to bottom,#007bff,#0056b3); /* Light Blue */
            text-align: center;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .left-section img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid white;
        }

        .left-section h2 {
            margin-top: 12px;
            font-size: 22px;
            color: white;
            font-weight: bold;
        }

        .left-section p {
            font-size: 15px;
            color: white;
        }

        /* Right Section - Doctor Details */
        .right-section {
            width: 60%;
            padding: 30px;
        }

        h3 {
            margin-bottom: 5px;
            color: #00264d;
            font-size: 18px;
            font-weight: bold;
        }

        p {
            margin: 6px 0;
            color: #666;
            font-size: 15px;
        }

        /* Details & Specialties */
        .details {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .details span {
            display: inline-block;
            background: #e3f2fd;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #003366;
        }

        /* Sections like Experience, Timings, Contact */
        .experience, .timings, .contact, .fees {
            margin-top: 18px;
            padding: 12px;
            background: #f0f8ff;
            border-radius: 8px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.08);
        }

        .experience h3, .timings h3, .contact h3, .fees h3 {
            margin-bottom: 6px;
            color: #003366;
            font-size: 16px;
        }

        input[type="submit"] {
                    margin-top: 20px;
                    padding: 10px;
                    width: 70%;
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

        /* Fee Box */
        .fee {
            margin-top: 20px;
            width: 25%;
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .fee:hover {
            background: #0056b3;
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
        .none-link{
            text-decoration: none;
            color: inherit;
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
        <a href="Patient_profile_management.php">Profile</a>
    </nav><br><br>

    <main>
        <div class="profile-card">
            <?php if ($doctor): ?>
                <div class="left-section">
                    <img src="<?php echo !empty($doctor['DProfilePic']) ? htmlspecialchars($doctor['DProfilePic']) : 'default-profile.png'; ?>" alt="Doctor Image">
                    <h2>Dr. <?php echo htmlspecialchars($doctor['DfirstName'] . " " . $doctor['DmiddleName'] . " " . $doctor['DlastName']); ?></h2>
                    <p><?php echo htmlspecialchars($doctor['Specialization']); ?></p>
                </div>
                <div class="right-section">
                    <div class="info-box"><h3>Email:</h3><p><?php echo htmlspecialchars($doctor['email']); ?></p></div>
                    <div class="info-box"><h3>Qualification:</h3><p><?php echo htmlspecialchars($doctor['Qualification']); ?></p></div>
                    <div class="info-box"><h3>Experience:</h3><p><?php echo htmlspecialchars($doctor['Expyear']) . " Years"; ?></p></div>
                    <div class="info-box"><h3>Working Hours:</h3><p><?php echo htmlspecialchars($doctor['start_time'] . " - " . $doctor['end_time']); ?></p></div>
                    <div class="info-box"><h3>Phone:</h3><p><?php echo htmlspecialchars($doctor['mobileNo']); ?></p></div>
                    <div class="info-box"><h3>Clinic:</h3><p><?php echo htmlspecialchars($doctor['clinic']); ?></p></div>
                    <div class="info-box"><h3>Fees:</h3><p>₹<?php echo htmlspecialchars($doctor['Dfees']); ?> INR</p></div>
                    <div class="info-box"><h3>Location:</h3><p><?php echo htmlspecialchars($doctor['Dcity'] . ", " . $doctor['Dstate'] . " - " . $doctor['Dpincode']); ?></p></div>
                    <center>
                        <a href="Appointment_form.php?doctor_email=<?php echo urlencode($doctor['email']); ?>" class="edit-btn">
                            <input type="submit" value="Apply for Appointment">
                        </a>

                    </center>

                </div>
            <?php else: ?>
                <p class="error">Doctor profile not found.</p>
            <?php endif; ?>
        </div>
    </main>
    <br>
    
    <br>
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
