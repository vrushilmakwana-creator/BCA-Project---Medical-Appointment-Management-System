<?php 
// Start session 
session_start(); 
 
// Connect to database 
$conn = new mysqli("localhost", "root", "", "medconnect"); 
 
// Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
 
// Check if form is submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['email']; 
    $password = $_POST['password'];
    $usertype = strtolower($_POST['usertype']); // Convert to lowercase
 
    // Check if email exists 
    $result = $conn->query("SELECT uname, pass, UserType FROM login WHERE email='$email'"); 
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['UserType'] = $usertype; // Store lowercase user type

        // Redirect based on user type
        if ($usertype == 'doctor') {
            header("Location: Doctor_home.php");
        } elseif ($usertype == 'patient') {
            header("Location: patient_home.php");
        } elseif ($usertype == 'admin') {
            header("Location: Admin_home.php");
        } else {
            echo "Invalid User Type!";
        }
        exit();
    } else {
        echo "Invalid credentials or user type!";
    }
    
    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc(); 
        
        // Check password 
        if ($password == $row['pass']) { // (Use password_hash() in real applications) 
            $_SESSION['user_id'] = $row['uname']; 
            header("Location: patient_home.php"); 
        } else { 
            echo "Wrong password!"; 
        } 
    } else { 
        echo "Email not found!"; 
    } 
} 
$conn->close(); 
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 5px;
            font-size: 26px;
            color: #333;
        }

        .sub-title {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
            width: 100%;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }
        
        input[type="name"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }
        
        .input-group select {  
            width: 100%;  
            padding: 10px;  
            font-size: 16px;  
            border: 1px solid #ccc;  
            border-radius: 5px;  
            outline: none;  
            transition: border 0.3s ease;  
            background-color: white;  
            appearance: none; /* Removes default styles */
            -webkit-appearance: none; /* Safari fix */
            -moz-appearance: none; /* Firefox fix */
            cursor: pointer; /* Ensures consistency with input fields */
            padding-right: 30px; /* Space for custom arrow */
            background-position: right 10px center;
            background-repeat: no-repeat;
        }

        /* Adds a simple custom arrow using pure CSS */
        .input-gang {  
            position: relative;  
        }

        .input-group::after {  
            content: "▼";  
            font-size: 12px;  
            color: #333;  
            position: absolute;  
            top: 50%;  
            right: 15px;  
            transform: translateY(-50%);  
            pointer-events: none; /* Ensures the arrow doesn’t interfere with clicks */
        }

        /* Highlight border when selected */
        .input-group select:focus {  
            border-color: #007bff;  
        }


        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            justify-content: space-between;
        }

        .remember-me input {
            margin-right: 5px;
        }

        .actions {
            margin-top: 20px;
        }

        .actions a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .register-text {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }

        .register-text a {
            color: #007bff;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
        }

        .forgot-password a {
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Welcome Back !!</h2>
        <p class="sub-title">Please login to continue</p><br>

        <form method="POST">
            <!-- User Type Input -->
            <div class="input-group"> 
                <label for="usertype">User Type:</label> 
                <select id="usertype" name="usertype" required>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <!-- Email Input -->
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>

            <!-- Password Input -->
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <label>
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="login-btn">Login</button>

            <!-- Actions -->
            <div class="actions">
                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>