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
    $spec = $conn->real_escape_string($_POST['spec']);
    $exp = $conn->real_escape_string($_POST['exp']);
    $age = (int)$_POST['age'];  
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
            $sql = "INSERT INTO dprofile (DfirstName, DmiddleName, DlastName, Dage, Dgender, Dstate, Ddob, email, clinic, Dcity, Dpincode, DProfilePic, Specialization, Expyear, start_time, end_time) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssss", $firstName, $middleName, $lastName, $age, $gender, $state, $dob, $email, $clinicAddress, $city, $pincode, $profilePhoto, $spec, $exp, $start_time, $end_time);
            
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

<!-- HTML FORM -->
<form method="POST" enctype="multipart/form-data">
    <label>First Name:</label>
    <input type="text" name="firstName" required><br>

    <label>Middle Name:</label>
    <input type="text" name="middleName"><br>

    <label>Last Name:</label>
    <input type="text" name="lastName" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Specialization:</label>
    <input type="text" name="spec" required><br>

    <label>Experience (Years):</label>
    <input type="number" name="exp" required><br>

    <label>Age:</label>
    <input type="number" name="age" required><br>

    <label>Date of Birth:</label>
    <input type="date" name="dob" required><br>

    <label>Clinic Address:</label>
    <input type="text" name="clinicAddress" required><br>

    <label>City:</label>
    <input type="text" name="city" required><br>

    <label>State:</label>
    <input type="text" name="state" required><br>

    <label>Pin Code:</label>
    <input type="text" name="pinCode" required><br>

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

    <input type="submit" value="Submit">
</form>