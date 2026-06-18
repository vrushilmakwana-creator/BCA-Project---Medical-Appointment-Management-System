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
    $PfirstName = $conn->real_escape_string($_POST['PfirstName']); 
    $PmiddleName = $conn->real_escape_string($_POST['PmiddleName']); 
    $PlastName = $conn->real_escape_string($_POST['PlastName']); 
    $age = (int)$_POST['age'];  
    $dob = $conn->real_escape_string($_POST['dob']); 
    $address = $conn->real_escape_string($_POST['address']); 
    $email = $conn->real_escape_string($_POST['email']); 
    $gender = $conn->real_escape_string($_POST['gender']); 
    $city = $conn->real_escape_string($_POST['city']); 
    $state = $conn->real_escape_string($_POST['state']); 
    $pincode = $conn->real_escape_string($_POST['pinCode']); 

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

        // Proceed only if there are no errors
        if (empty($errorMessage)) {
            $sql = "INSERT INTO pprofile (PfirstName, PmiddleName, PlastName, Page, Gender, Pstate, Pdob, email, PAddress, Pcity, Ppincode, PProfilePic) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssss", $PfirstName, $PmiddleName, $PlastName, $age, $gender, $state, $dob, $email, $address, $city, $pincode, $profilePhoto);
            
            if ($stmt->execute()) { 
                header("Location: Patient_profile.php");
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
    <title>Patient Profile Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light Blue */
            color: #333;
            margin: 0;
            padding: 0;
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
            color: #333; /* Soothing green */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
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
<div class="container">
        <center><h1><b>Patient Profile Management</b></h1></center>
        <form method="POST" enctype="multipart/form-data">
            <label for="patientName">First Name:</label>
            <input type="text" id="PfirstName" name="PfirstName" placeholder="Enter your first name" required>
            
            <label for="patientName">Middle Name:</label>
            <input type="text" id="PmiddleName" name="PmiddleName" placeholder="Enter your middle name" required>
            
            <label for="patientName">Last Name:</label>
            <input type="text" id="PlastName" name="PlastName" placeholder="Enter your last name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" placeholder="Enter your age" required>
            
            <label for="patientName">Enter Date Of Birth:</label>
            <input type="date" id="dob" name="dob" placeholder="Enter your birth date" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select your gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="address">Address:</label>
            <textarea id="address" name="address" placeholder="Enter your address" required></textarea>
       
            <label for="city">City</label>
            <input type="text" id="city" placeholder="Enter your city name" name="city" required>

            <label for="state">State</label>
            <input type="text" id="state" placeholder="Enter your State name" name="state" required>

            <label for="pinCode">Pin Code</label>
            <input type="text" id="pinCode" placeholder="Enter your pin code" name="pinCode" required>
            
            <label for="profilePhoto">Add Profile Photo</label>
            <input type="file" id="profilePhoto" name="profilePhoto" accept=".jpg, .jpeg" required>

                <!-- Display error message near the submit button -->
    <?php if (!empty($errorMessage)): ?>
        <p style="color: red; font-size: 14px; margin-top: 5px;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
        
            <input type="submit" value="Submit">
        </form>
        <div class="footer">
            © 2025 Medical Appointment Management
        </div>
    </div>
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
