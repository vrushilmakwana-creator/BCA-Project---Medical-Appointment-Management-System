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
$sql = "SELECT uname, UserType, email, mobileNo FROM login";
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            width: 100%;
        }

        header {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        .header-container, .footer-container {
            width: 100%;
            background-color: #f5f5f5;
            padding: 10px 0;
            text-align: center;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .main-container > * {
            margin-bottom: 20px;
            width: 100%;
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
            border-radius: 5px;
        }

        nav {
            display: flex;
            justify-content: center;
            background: #333;
            color: #fff;
            padding: 10px;
            width: 100%;
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
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
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
            background: #f5f5f5;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            width: 100%;
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

        input[type="submit"] {
            margin-top: 20px;
            width: 80%;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search {
            display: flex;
            align-items: center;
            width: 100%;
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

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }

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

        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
            text-align: center;
            font-size: 16px;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .show {
            display: block;
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
            content: "";  
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
            width: 400px;
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
        <a href="Admin.php">Home</a>
        <a href="admin_messages.php">Messages</a>
    </nav>
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
<br><br>
    <div class="login-container"> 
        <h2>Add Admin</h2><br> 
        <form method="POST"> 
            <div class="input-group"> 
                <label for="name">Name:</label> 
                <input type="name" name="newAdminUname" placeholder="Enter Username" required> 
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
            <a href="">Documentation</a>
        </div>
        <div>IG : vrushilmakwana</div>
    
    </footer>
    </div>
</body>
</html>