
<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "medconnect";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctor's email from session
$doctor_email = $_SESSION['email'] ?? '';

if (!$doctor_email) {
    die("Doctor email not found in session.");
}

// Fetch pending requests assigned to the doctor with full patient details
$sql = "SELECT rd.request_id, rd.patient_email, rd.appointment_date, rd.appointment_time, rd.symptoms, rd.other_symptom, 
               rd.severity, rd.duration, rd.existing_conditions, rd.travel_history, rd.allergies,
               pp.PProfilePic, pp.PfirstName, pp.PmiddleName, pp.PlastName 
        FROM request_data rd
        LEFT JOIN pprofile pp ON rd.patient_email = pp.email
        WHERE rd.doctor_email = ? AND rd.status = 'Pending'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $doctor_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Requests</title>
    <style>
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
        }*{
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
        .main{
            width: 100%;
            display: flex;
            align-items:center;
            justify-content: space-around;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .request-container {
            width: 45%;
            margin: 1rem;
        }
        .request-card {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }
        .profile-section {
            width: 15%;
            text-align: center;
        }
        .profile-section img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid #007bff;
        }
        .details-section {
            flex: 1;
            padding-left: 20px;
        }
        .details-section p {
            margin: 5px 0;
            font-size: 14px;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .buttons button {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }
        .accept {
            background: #28a745;
            color: white;
        }
        .decline {
            background: #dc3545;
            color: white;
        }
        .no-requests {
            text-align: center;
            color: #777;
            margin-top: 20px;
        }
        /* Doctor List Styling */
        .doctor-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 20px;
        }
        .doctor-card {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }
        .doctor-photo {
            background: #f0f0f0;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .doctor-photo img {
            width: 500px;
            height: 500px;
            border-radius: 70%;
        }
        .doctor-info {
            flex-grow: 1;
            padding: 15px;
            background: white;
        }
        .doctor-info h3 {
            margin: 5px 0;
            color: #333;
        }
        .doctor-info p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }
        button[type="submit"] {
            margin-top: 18px;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #007bff;
            text-decoration: none;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 20px;
            margin-top: 2px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-right: 25px;
        }
        .btn:hover {
            background-color: #007bff;
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
        
        .logo {
            max-width: 160px;
            height: auto;
            display: block;
            margin: 10px;
        }
        input[type="btn"] {
            margin-top: 13px;
            padding: 7px;
            font-size: 17px;
            color: white;
            text-align: center;
            background-color: #007bff;
            border: none;
            width: 35%;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="btn"]:hover {
            background-color: #007bff;
            /*            text-decoration: underline;*/
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
/*        .request-container {
            width: 80%;
            margin: auto;*/
        /*}*/
        .request-container {
            width: 45%;
            /* margin: auto; */
            margin: 1rem;
        }
        .request-card {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 18px 97px;
            background: #fff;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 14px;
            gap: 8rem;
        }
        .profile-section {
            width: 15%;
            height: 100%;
            text-align: center;
        }       
/*        .profile-section {
            width: 15%;
            text-align: center;
        }*/
        .profile-section img {
            width: 170px;
            height: 170px;
            background-color: #007bff;
            border-radius: 50%;
            border: 2px solid #007bff;
        }
        .details-section {
            flex: 1;
            padding-left: 20px;
        }
        .details-section p {
            margin: 5px 0;
            font-size: 14px;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .buttons button {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }
        .accept {
            background: #28a745;
            color: white;
        }
        .decline {
            background: #dc3545;
            color: white;
        }
        .no-requests {
            text-align: center;
            color: #777;
            margin-top: 20px;
        }
        
        .none-link{
            text-decoration: none;
            color: inherit;
        }
        div {
            display: block;
            unicode-bidi: isolate;
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
<b><h1 style="text-align: center;">Pending Requests</h1></b><br><br>
<div class="main">
<div class="request-container">

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="request-card">
            <div class="profile-section">
                <img src="<?= htmlspecialchars($row['PProfilePic'] ?: 'default-profile.png'); ?>" alt="Profile Picture">
            </div>
            <div class="details-section">
                <strong><?= htmlspecialchars($row['PfirstName'] . " " . $row['PmiddleName'] . " " . $row['PlastName']); ?></strong>
                <p>Email: <?= htmlspecialchars($row['patient_email']); ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($row['appointment_date']); ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($row['appointment_time']); ?></p>
                <p><strong>Symptoms:</strong> <?= htmlspecialchars($row['symptoms']); ?></p>
                <p><strong>Other Symptoms:</strong> <?= htmlspecialchars($row['other_symptom']); ?></p>
                <p><strong>Severity:</strong> <?= htmlspecialchars($row['severity']); ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($row['duration']); ?></p>
                <p><strong>Existing Conditions:</strong> <?= htmlspecialchars($row['existing_conditions']); ?></p>
                <p><strong>Recently Travelled?:</strong> <?= htmlspecialchars($row['travel_history']); ?></p>
                <p><strong>Have Allergies:</strong> <?= htmlspecialchars($row['allergies']); ?></p>

                <div class="buttons">
                    <form method="POST">
                        <a href="view_patient_profile.php?email=<?= urlencode($row['patient_email']); ?>" class="none-link"><input type="btn" value="Visit Profile"></a>
                        <input type="hidden" name="request_id" value="<?= $row['request_id']; ?>">
                        <button type="submit" name="accept" class="accept">Accept</button>
                        <button type="submit" name="decline" class="decline">Decline</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p class="no-requests">No pending requests.</p>
<?php endif; ?>
<br><br>
</div>
</div>
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

<?php
// Handle Accept/Decline actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'] ?? null;

    if ($request_id) {
        $conn = new mysqli($host, $user, $pass, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['accept'])) {
            $update_sql = "UPDATE request_data SET status = 'Confirmed' WHERE request_id = ?";
        } elseif (isset($_POST['decline'])) {
            $update_sql = "UPDATE request_data SET status = 'Rejected' WHERE request_id = ?";
        }

        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $request_id);
        if ($update_stmt->execute()) {
            echo "<script>alert('Request updated successfully.'); window.location.reload();</script>";
        } else {
            echo "<script>alert('Error updating request.');</script>";
        }

        $update_stmt->close();
        $conn->close();
    }
}
?>