<?php 
$errorMessage = ""; // Variable to store error message

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Database configuration 
    $servername = "localhost"; 
    $dbUsername = "root"; 
    $dbPassword = ""; 
    $dbname = "medconnect"; 

    // Create a connection 
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname); 

    // Check connection 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    } 

    // Get form data safely 
    $firstName = $conn->real_escape_string($_POST['firstName']); 
    $middleName = $conn->real_escape_string($_POST['middleName']); 
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $qualification = $conn->real_escape_string($_POST['qualification']);
    $spec = $conn->real_escape_string($_POST['spec']);
    $exp = $conn->real_escape_string($_POST['exp']);
    $age = (int)$_POST['age']; 
    $fees = (int)$_POST['fees'];
    $dob = $conn->real_escape_string($_POST['dob']); 
    $clinicAddress = $conn->real_escape_string($_POST['clinicAddress']); 
    $email = $conn->real_escape_string($_POST['email']); 
    $gender = $conn->real_escape_string($_POST['gender']); 
    $city = $conn->real_escape_string($_POST['city']); 
    $state = $conn->real_escape_string($_POST['state']); 
    $pincode = $conn->real_escape_string($_POST['pinCode']); 
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);

    // Check if email exists in login table
    $checkEmailQuery = "SELECT email FROM login WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $errorMessage = "Email does not match. Please enter a registered email.";
    } else {
        $profilePhoto = "uploads/default.jpg"; // Default image 

        // Handling profile photo upload  
        if (!empty($_FILES["profilePhoto"]["name"])) { 
            $targetDir = "uploads/"; // Folder to store images
            $fileName = time() . "_" . basename($_FILES["profilePhoto"]["name"]); // Unique filename
            $targetFilePath = $targetDir . $fileName; 
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Allowed file types & size constraint
            $allowedTypes = ["jpg", "jpeg"];
            if (!in_array($fileType, $allowedTypes)) {
                $errorMessage = "Only JPG and JPEG files are allowed.";
            } elseif ($_FILES["profilePhoto"]["size"] > 5 * 1024 * 1024) {
                $errorMessage = "File size must be 5MB or less.";
            } else {
                if (move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], $targetFilePath)) {
                    $profilePhoto = $targetFilePath; // Set uploaded file path
                } else {
                    $errorMessage = "Error uploading file.";
                }
            }
        }

        // Time slot validation
        if (strtotime($start_time) >= strtotime($end_time)) {
            $errorMessage = "Slot time must be selected.";
        }

        // Proceed only if there are no errors
        if (empty($errorMessage)) {
            $sql = "UPDATE dprofile 
                    SET DfirstName = ?, DmiddleName = ?, DlastName = ?, Qualification = ?, Dage = ?, Dgender = ?, 
                        Dstate = ?, Ddob = ?, clinic = ?, Dcity = ?, Dpincode = ?, DProfilePic = ?, Specialization = ?, 
                        Expyear = ?, start_time = ?, end_time = ?, Dfees = ? 
                    WHERE email = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssssss", 
                $firstName, $middleName, $lastName, $qualification, $age, $gender, $state, 
                $dob, $clinicAddress, $city, $pincode, $profilePhoto, $spec, $exp, 
                $start_time, $end_time, $fees, $email
            );

            if ($stmt->execute()) { 
                header("Location: Doctor_profile.php");
                exit();
            }
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Doctor Profile</title> 
    <style> 
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
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
        .actions a:hover {
            text-decoration: underline;
            background-color: #0056b3;
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
        .profile-container { 
            padding: 20px; 
            max-width: 700px; 
            margin: auto; 
        } 
        .profile-card { 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            background: #f9f9f9; 
            text-align: center; 
        } 
        .profile-card h2 { 
            margin-bottom: 10px; 
        } 
        .profile-card p { 
            margin: 5px 0; 
        } 
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        } 
        table, th, td { 
            border: 1px solid #ddd; 
        } 
        th, td { 
            padding: 8px; 
            text-align: center; 
        } 
        .add-btn { 
            margin-top: 10px; 
            padding: 8px; 
            background: #007bff; 
            color: white; 
            border: none; 
            cursor: pointer; 
        } 
        .add-btn:hover { 
            background: #0056b3; 
        } 
        .clinic-photo { 
            width: 100%; 
            max-height: 200px; 
            border-radius: 5px; 
            margin-top: 10px; 
            object-fit: cover; 
        }
        
        input[type="date"],
        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea,
        select {
            margin-top: 5px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }
        input[type="srch"]
        {
            margin-top: 5px;
            padding: 0px;
            margin-left: 15px;
            font-size: 16px;
            margin-right: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            width: 300px;
        }
        .actions a:hover {
            text-decoration: underline;
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

        textarea {
            resize: vertical;
            height: 80px;
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
        h2 {
            text-align: center;
            color: #333; /* Soothing green */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }
        textarea {
            resize: vertical;
            height: 70px;
        }
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
         }
        .search {
            display: inherit;
            align-items: center;
        }
        .search input {
            width: 90%;
            padding: 0px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        .search button {
            background: #007bff;
            color: white;
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
        input[type="submit"] {
            margin-top: 20px;
            width: 40%;
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
        .logo{
              max-width: 160px;
              height: auto;
              display: block;
              margin: 10px;
        }
    </style> 
    <script> 
        function addScheduleRow() { 
            var table = document.getElementById("scheduleTable"); 
            var newRow = table.insertRow(); 
            newRow.innerHTML = ` 
                <td><input type="text" placeholder="Day"></td> 
                <td><input type="time"></td> 
                <td><input type="time"></td> 
                <td><button onclick="removeRow(this)">
 ❌
 </button></td> 
            `; 
        } 
 
        function removeRow(button) { 
            var row = button.parentNode.parentNode; 
            row.parentNode.removeChild(row); 
        } 
    </script> 
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
            <input type="srch" name="query" id="searchBox" placeholder="Search by name, specialization or location..">
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
    </nav> 
    <div class="profile-container"> 
        <div class="profile-card">
             
        <!-- HTML FORM -->
        <form method="POST" enctype="multipart/form-data">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstName" placeholder="Enter your first name" required><br>

            <label>Middle Name:</label>
            <input type="text" name="middleName" placeholder="Enter your middle name" ><br>

            <label>Last Name:</label>
            <input type="text" name="lastName" placeholder="Enter your last name" required><br>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter your age" required><br>

            <label>Qualification:</label>
            <input type="text" name="qualification" placeholder="MBBS,BHMS,etc." required><br>

            <label>Specialization:</label>
            <input type="text" name="spec" placeholder="Pediatrician,Neurologist,etc." required><br>

            <label>Experience (Years):</label>
            <input type="number" name="exp" placeholder="Enter your age" required><br>
            
            <label>Fees:</label>
            <input type="text" name="fees" placeholder="Enter your fees in INR" required><br>

            <label>Age:</label>
            <input type="number" name="age" placeholder="Enter your age" required><br>

            <label>Date of Birth:</label>
            <input type="date" name="dob" placeholder="Enter your age" required><br>

            <label>Clinic Address:</label>
            <input type="text" name="clinicAddress" placeholder="Enter your age" required><br>

            <label>City:</label>
            <input type="text" name="city" placeholder="Enter your age" required><br>

            <label>State:</label>
            <input type="text" name="state" placeholder="Enter your age" required><br>

            <label>Pin Code:</label>
            <input type="text" name="pinCode" placeholder="Enter your age" required><br>

            <label>Gender:</label>
            <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>

            <label>Start Time:</label>
            <select name="start_time">
                <?php
                for ($hour = 9; $hour <= 22; $hour++) {
                    foreach (["00", "30"] as $minutes) {
                        $time = sprintf("%02d:%02d", $hour, $minutes);
                        $formattedTime = date("g:i A", strtotime($time));
                        echo "<option value='$formattedTime'>$formattedTime</option>";
                    }
                }
                ?>
            </select><br>

            <label>End Time:</label>
            <select name="end_time">
                <?php
                for ($hour = 9; $hour <= 22; $hour++) {
                    foreach (["00", "30"] as $minutes) {
                        $time = sprintf("%02d:%02d", $hour, $minutes);
                        $formattedTime = date("g:i A", strtotime($time));
                        echo "<option value='$formattedTime'>$formattedTime</option>";
                    }
                }
                ?>
            </select><br>

            <label>Profile Photo:</label>
            <input type="file" name="profilePhoto"><br>

            <!-- Display error messages above the submit button -->
            <?php if (!empty($errorMessage)) echo "<div style='color:red;'>$errorMessage</div>"; ?>

            <center><input type="submit" value="Submit"></center>
        </form>
        </div>
    </div>
    <?php if (!empty($errorMessage)): ?>
    <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
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