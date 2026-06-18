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

$email = $_SESSION['email'];


// Fetch doctor profile details
$stmt = $conn->prepare("SELECT DfirstName, DmiddleName, DlastName, mobileNo, Qualification, Dage, Dgender, Dstate, Ddob, email, clinic, Dcity, Dpincode, DProfilePic, Specialization, Expyear, start_time, end_time, Dfees FROM dprofile WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
} else {
    die("Doctor profile not found.");
}
error_reporting(0);
ini_set('display_errors', 0);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
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
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
         }
        .search {
            display: flex;
            align-items: center;
        }
        .search input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        .search button {
            background: #007bff;
            color: white;
            margin-top: 0;
            border: none;
            padding: 7px;
            cursor: pointer;
            border-radius: 0 4px 6px 0;
            font-size: 17px;
        }
        .search button:hover {
            background: #0056b3;
        }
        /* Container for the dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Three-dot button */
        .dropbtn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 120px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
            text-align: center;
            font-size: 16px;
        }

        /* Hover effect */
        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        /* Show the dropdown when active */
        .show {
            display: block;
        }
    </style>
</head>
<body>

    <script>
        function toggleDropdown() {
            document.getElementById("dropdownMenu").classList.toggle("show");
        }

        // Close dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    if (dropdowns[i].classList.contains('show')) {
                        dropdowns[i].classList.remove('show');
                    }
                }
            }
        }
    </script>

    <header>
        <img src="Official_LOGO_MedicalAppointmwntManagement.png" alt="logo" class="logo">
        <form action="Search_results.php" method="POST" class="search">
            <input type="text" name="query" id="searchBox" placeholder="Search by name, specialization or location..">
            <button type="submit" id="searchButton">🔍</button>
        </form>
        &nbsp &nbsp &nbsp
        <div class="dropdown">
            <!-- Three-dot button -->
            <button class="dropbtn" onclick="toggleDropdown()">&#x22EE;</button>

            <!-- Dropdown content -->
            <div class="dropdown-content" id="dropdownMenu">
                <a href="Log_out.php">Log Out</a>
            </div>
        </div>
    </header>
    <nav>
        <a href="Doctor_home.php">Home</a>
        <a href="Request_page.php">Requests</a>
        <a href="Quiz_232.php">Payment</a>
        <a href="Doctor_profile.php">Profile</a>
    </nav><br><br>
    
    <main>
        <div class="profile-card">
            <div class="left-section">
                <img src="<?php echo htmlspecialchars($doctor['DProfilePic']); ?>" alt="Profile Image">
                <h2><?php echo htmlspecialchars($doctor['DfirstName'] . " " . $doctor['DmiddleName'] . " " . $doctor['DlastName']); ?></h2>
                <p><?php echo htmlspecialchars($doctor['Specialization']); ?></p>
            </div>

            <div class="right-section">
                <div class="info-box">
                    <h3>QUALIFICATION</h3>
                    <p><?php echo htmlspecialchars($doctor['Qualification']); ?></p>
                </div>

                <div class="info-box">
                    <h3>EXPERIENCE</h3>
                    <p><?php echo htmlspecialchars($doctor['Expyear']) . " Years"; ?></p>
                </div>

                <div class="info-box">
                    <h3>WORKING HOURS</h3>
                    <p><?php echo htmlspecialchars($doctor['start_time'] . " - " . $doctor['end_time']); ?></p>
                </div>

                <div class="info-box">
                    <h3>EMAIL</h3>
                    <p><?php echo htmlspecialchars($doctor['email']); ?></p>
                </div>
                
                <div class="info-box">
                    <h3>CONTACT NO.</h3>
                    <p>+91 <?php echo htmlspecialchars($doctor['mobileNo']); ?></p>
                </div>

                <div class="info-box">
                    <h3>CLINIC</h3>
                    <p><?php echo htmlspecialchars($doctor['clinic']); ?></p>
                </div>
                
                <div class="info-box">
                    <h3>Fees</h3>
                    <p><?php echo htmlspecialchars($doctor['Dfees']); ?> /- INR</p>
                </div>

                <div class="info-box">
                    <h3>LOCATION</h3>
                    <p><?php echo htmlspecialchars($doctor['Dcity'] . ", " . $doctor['Dstate'] . " - " . $doctor['Dpincode']); ?></p>
                </div>
                <center><a href="Doctor_profile_management.php" class="edit-btn"><input type="submit" value="Edit Profile"></a></center>
            </div>
        </div>
    </main>
   <footer>
        <div>
            <a href="Help_doctor.php">Help</a>
            <a href="Privacy_policy_doctor.php">Privacy Policy</a>
            <a href="Contact_us_doctor.php">Contact Us</a>
            <a href="">Documentation</a>
            <a href="About_us_doctor.php">About Us</a>
            <a href="FAQ_doctor.php">FAQ</a>
        </div>
        <div>IG : vrushilmakwana</div>
    </footer>

</body>
</html>