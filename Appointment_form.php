
<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "medconnect";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    die("Access Denied. Please log in.");
}

// Get logged-in patient's email (from login table)
$patient_email = $_SESSION['email'];

// Get doctor's email from URL parameter
if (!isset($_GET['doctor_email'])) {
    die("Invalid access. No doctor selected.");
}
$doctor_email = $_GET['doctor_email'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $selected_symptom = $_POST['symptom'];
    $custom_symptom = trim($_POST['custom_symptom']);
    $final_symptom = !empty($custom_symptom) ? $custom_symptom : $selected_symptom;
    
    // New fields
    $duration = $_POST['duration'];
    $severity = $_POST['severity'];
    $existing_conditions = isset($_POST['conditions']) ? implode(", ", $_POST['conditions']) : "None";
    $travel_history = $_POST['travel'];
    $allergies = $_POST['allergies'];
    $allergy_details = !empty($_POST['allergy_details']) ? $_POST['allergy_details'] : "None";
    $location = $_POST['location'];
    $preferred_days = isset($_POST['days']) ? implode(", ", $_POST['days']) : "None";

    // Insert into request_data
    $stmt = $conn->prepare("INSERT INTO request_data 
        (patient_email, doctor_email, appointment_date, appointment_time, symptoms, other_symptom, duration, severity, existing_conditions, travel_history, allergies, allergy_details, location, preferred_days) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssssssssss", 
        $patient_email, $doctor_email, $appointment_date, $appointment_time, 
        $selected_symptom, $custom_symptom, $duration, $severity, 
        $existing_conditions, $travel_history, $allergies, $allergy_details, 
        $location, $preferred_days);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment request submitted successfully!'); window.location.href='patient_home.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Appointment</title>
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
    }.container { 
      max-width: 600px; 
      margin: 40px auto; 
      background: #fff; 
      padding: 20px 30px; 
      border-radius: 8px; 
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
    } 
    h2 { 
      text-align: center; 
      color: #333; 
    } 
    label { 
      font-weight: bold; 
      display: block; 
      font-size: 20px;
      margin: 15px 0 5px; 
    } 
    input[type="text"], 
    select, 
    textarea { 
      width: 100%; 
      padding: 10px; 
      margin-top: 5px;
      border: 1px solid #ccc; 
      border-radius: 4px; 
      box-sizing: border-box;
      text-size: 18px;
    } 
    input[type="checkbox"], 
    input[type="radio"] { 
      margin-right: 5px; 
    } 
    .question { 
      margin-bottom: 20px; 
    } 
    .submit-btn { 
      width: 100%; 
      padding: 12px; 
      background: #007BFF; 
      border: none; 
      color: #fff; 
      font-size: 16px; 
      border-radius: 4px; 
      cursor: pointer; 
    } 
    .submit-btn:hover { 
      background: #0056b3; 
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

    body { 
      font-family: Arial, sans-serif; 
      background: #f9f9f9; 
      margin: 0; 
      padding: 0; 
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
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
         }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
            border-radius: 4px;
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
table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
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
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
            margin-top: 5px;
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
        <a href="patient_home.php">Home</a>
        <a href="Appointment_page.php">Appointment</a>
        <a href="Quiz_232.php">Quiz</a>
        <a href="Patient_profile.php">Profile</a>
    </nav>
    <br>
    
    <br>
    <center><b><h1>Request Appointment</h1></b></center>
    <form method="post">
        <label>Appointment Date:</label>
        <input type="date" name="appointment_date" required><br>

        <label>Appointment Time:</label>
        <input type="time" name="appointment_time" required><br>

        <label>Symptoms:</label>
        <select name="symptom">
            <option value="Fever">Fever</option>
            <option value="Cough">Cough</option>
            <option value="Headache">Headache</option>
            <option value="Stomach Pain">Stomach Pain</option>
            <option value="Skin Rash">Skin Rash</option>
            <option value="Joint Pain">Joint Pain</option>
        </select>

        <label>Other Symptoms (Optional):</label>
        <input type="text" name="custom_symptom" placeholder="Describe your symptoms"><br>

        <label>How long have you had these symptoms?</label>
        <select name="duration">
            <option value="Less than 24 hours">Less than 24 hours</option>
            <option value="1-3 days">1-3 days</option>
            <option value="4-7 days">4-7 days</option>
            <option value="More than a week">More than a week</option>
        </select><br>

        <label>How severe are your symptoms?</label>
        <select name="severity">
            <option value="Mild">Mild (manageable discomfort)</option>
            <option value="Moderate">Moderate (affecting daily activities)</option>
            <option value="Severe">Severe (requires immediate attention)</option>
        </select><br>

        <label>Do you have any existing medical conditions? (Select all that apply)</label><br>
        <input type="checkbox" name="conditions[]" value="Diabetes"> Diabetes<br>
        <input type="checkbox" name="conditions[]" value="Hypertension"> Hypertension<br>
        <input type="checkbox" name="conditions[]" value="Heart Disease"> Heart Disease<br>
        <input type="checkbox" name="conditions[]" value="Asthma"> Asthma<br>
        <input type="checkbox" name="conditions[]" value="None"> None<br>

        <label>Have you recently traveled?</label><br>
        <input type="radio" name="travel" value="Yes"> Yes<br>
        <input type="radio" name="travel" value="No"> No<br>

        <label>Do you have any known allergies to medications?</label><br>
        <input type="radio" name="allergies" value="Yes"> Yes<br>
        <input type="radio" name="allergies" value="No"> No<br>

        <label>If yes, please specify:</label>
        <input type="text" name="allergy_details" placeholder="Describe allergies"><br>

        <label>Location:</label>
        <input type="text" name="location" placeholder="City or Area"><br>

        <label>Preferred Appointment Days:</label><br>
        <input type="checkbox" name="days[]" value="Monday"> Monday<br>
        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday<br>
        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday<br>
        <input type="checkbox" name="days[]" value="Thursday"> Thursday<br>
        <input type="checkbox" name="days[]" value="Friday"> Friday<br>
        <input type="checkbox" name="days[]" value="Saturday"> Saturday<br>

        <center><input type="submit" value="Submit Request"></center>
    </form>
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