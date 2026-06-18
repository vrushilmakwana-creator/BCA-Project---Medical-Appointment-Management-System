<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Database configuration – update these as needed 
    $servername = "localhost"; 
    $dbUsername = "root"; 
    $dbPassword = ""; // Update if needed 
    $dbname = "medconnect"; // Change to your database name 
 
    // Create a connection 
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname); 
    // Check connection 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    } 
 
    // Get form data safely 
    $name = $conn->real_escape_string($_POST['name']); 
    $mobile = $conn->real_escape_string($_POST['mobile']); 
    $email = $conn->real_escape_string($_POST['email']); 
    $password = $_POST['password']; 
    $confirm_password = $_POST['password1'];
    $usertype = strtolower($_POST['usertype']);
 
    // Validate password match 
    if ($password !== $confirm_password) { 
        echo "<p style='color:red;'>Passwords do not match.</p>"; 
    } else { 
        // Insert query 
        $sql = "INSERT INTO login (uname, mobileNo, email, pass, UserType) VALUES ('$name', '$mobile', 
'$email', '$password', '$usertype')"; 
 
        if($conn->query($sql)===TRUE) 
            { 
                header("Location: registration_success.php"); 
                exit(); 
            } 
        else 
        { 
           echo "Error:".$sql."<br>".$conn->error; 
        } 
    } 
    $conn->close(); 
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        input[type="mobile"], 
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

        input[type="email"]:focus, 
        input[type="password"]:focus { 
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
                .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container"> 
        <h2>Create Account</h2><br> 
        <form method="POST"> 
            <div class="input-group"> 
                <label for="name">Name:</label> 
                <input type="name" name="name" placeholder="Enter your name" required> 
            </div>
            <div class="input-group"> 
                <label for="usertype">User Type:</label> 
                <select id="usertype" name="usertype" required>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                </select>
            </div>
            <div class="input-group"> 
                <label for="mobile">Phone Number:</label> 
                <input type="mobile" name="mobile" placeholder="Enter your mobile number" 
required> 
            </div> 
            <div class="input-group"> 
                <label for="email">Email:</label> 
                <input type="email" name="email" placeholder="Enter your email" required> 
            </div> 
            <div class="input-group"> 
                <label for="password">Password:</label> 
                <input type="password" name="password" placeholder="Enter password" required> 
            </div> 
            <div class="input-group"> 
                <label for="password">Re-enter Password:</label> 
                <input type="password" name="password1" placeholder="Re-enter password" 
required> 
            </div> 
            <button type="submit" class="login-btn">Register</button> 
            <br>
            <div class="login-link">
                Already have an account?&nbsp;<a href="Login_22bca232.php">Login Here</a>
            </div>
        </form>
</body>
</html>