<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medconnect";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users except the current admin
$sql = "SELECT uname, UserType, email, mobileNo FROM login WHERE UserType != 'admin'";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $uname = $_POST['uname'];
        $deleteQuery = "DELETE FROM login WHERE uname='$uname'";
        $conn->query($deleteQuery);
        echo "<script>alert('User Removed!'); window.location.reload();</script>";
    } elseif (isset($_POST['addAdmin'])) {
        $newAdminUname = $_POST['newAdminUname'];
        $newAdminPass = password_hash($_POST['newAdminPass'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $mobileNo = $_POST['mobileNo'];

        $insertQuery = "INSERT INTO login (uname, pass, UserType, email, mobileNo) 
                        VALUES ('$newAdminUname', '$newAdminPass', 'admin', '$email', '$mobileNo')";
        $conn->query($insertQuery);
        echo "<script>alert('Admin Added!'); window.location.reload();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admimn Home Page</title>
    <style>
        header {
            display: flex;
            width: 90%;
            margin: 0 auto;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        .header-container{
            width: 100%;
            background-color: #f5f5f5;
            padding: 10px 0;
        }
        .footer-container{
            width: 100%;
            background-color: #f5f5f5;
            padding: 10px 0;
        }
        .main-container{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            
        }
        .main-container > *{
            margin-bottom: 20px;
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
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: white;
        }
        button {
            padding: 8px 12px;
            margin: 5px;
            cursor: pointer;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
        }
        .add-admin-form {
            margin-top: 20px;
            background: white;
            padding: 20px;
            display: inline-block;
        }
        .add-admin-form input {
            padding: 8px;
            margin: 5px;
            width: 80%;
        }
        .add-btn {
            background-color: green;
            color: white;
            border: none;
        }
        footer {
            padding: 10px 20px;
            width: 90%;
            margin: 0 auto;
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
    </style>
</head>
<body>
    <div class="main-container">
   
    <br>
    <p><b><center><h1>Admin Page</h1></center></b></p> 
    
    <br>
    <h2>Manage Users</h2>
<table>
    <tr>
        <th>Username</th>
        <th>User Type</th>
        <th>Email</th>
        <th>Mobile No</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['uname']; ?></td>
        <td><?php echo $row['UserType']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['mobileNo']; ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="uname" value="<?php echo $row['uname']; ?>">
                <button type="submit" class="delete-btn" name="delete">Remove</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

    <div class="login-container"> 
        <h2>Add Admin</h2><br> 
        <form method="POST"> 
            <div class="input-group"> 
                <label for="name">Name:</label> 
                <input type="name" name="newAdminUname" placeholder="Enter Usernamee" required> 
            </div>
            
            <div class="input-group"> 
                <label for="password">Password:</label> 
                <input type="password" name="newAdminPass" placeholder="Enter password" required> 
            </div> 

            <div class="input-group"> 
                <label for="email">Email:</label> 
                <input type="email" name="email" placeholder="Enter Email" required> 
            </div> 
            
            
            <div class="input-group"> 
                <label for="mobile">Phone Number:</label> 
                <input type="mobile" name="mobile" placeholder="Enter Mobile number" 
required> 
            </div> 
            
            <button type="submit" name="addAdmin" class="login-btn">Add Admin</button> 
    </div>
        </form>
    <br>
    <footer class="footer-container">
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
    </div>
</body>
</html>