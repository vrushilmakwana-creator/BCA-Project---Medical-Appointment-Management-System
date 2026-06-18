<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "medconnect";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $emailAdd = $conn->real_escape_string($_POST['emailAdd']);
    $msg = $conn->real_escape_string($_POST['msg']);

    $sql = "INSERT INTO contact_us (full_name, email_add, message) VALUES ('$fullname', '$emailAdd', '$msg')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Contact Us</title> 
    <style> 
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background-color: #f0f8ff; 
            color: #333; 
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
        main { 
            padding: 20px; 
        } 
        .contact-section { 
            background-color: white; 
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
            border-radius: 10px; 
            padding: 10px; 
            margin: 10px 0; 
        } 
        input, textarea, button { 
            width: 40%; 
            padding: 10px; 
            margin: 10px 450px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        } 
        button { 
            background-color: #0078d4; 
            color: white; 
            border: none; 
            cursor: pointer; 
        } 
        button:hover { 
            background-color: #005bb5; 
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
            width: 200%;
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
        <a href="patient_home.php">Home</a>
        <a href="Appointment_page.php">Appointment</a>
        <a href="Quiz_232.php">Quiz</a>
        <a href="Patient_profile.php">Profile</a>
    </nav> 
    <main> 
        <h1>Contact Us</h1> 
        <div class="contact-section"> 
            <h2><i>Reach Out to Us :</i></h2><br> 
            <p><strong><u>Address</u>:</strong> Near tressury office, Kheda-387411</p> 
            <p><strong><u>Phone</u>:</strong> +91 63569 11912</p> 
            <p><strong><u>Email</u>:</strong> vrushilmakwana@gmail.com</p>    
        </div> 
        <form method="post">
            </br><h2><center><i>Send a Message :</i></center></h2><br>
            <center><input type="text" name="fullname" placeholder="Full Name" required> <br>
            <input type="email" name="emailAdd" placeholder="Email Address" required> <br>
            <textarea name="msg" rows="5" maxlength="255" required placeholder="Your Message" id="messageBox"></textarea></center>
            <center><h5><p id="charCount">0 / 255 characters</p></h5></center>

            <script>
            document.getElementById("messageBox").addEventListener("input", function () {
                let maxLength = 255;
                let currentLength = this.value.length;

                document.getElementById("charCount").textContent = currentLength + " / " + maxLength + " characters";
            });
            </script>
            <br>
            <center><button type="submit">Send</button></center> 
            </form> 
    </main> 
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