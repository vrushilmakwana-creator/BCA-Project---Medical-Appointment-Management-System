<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Privacy Policy - Medical Appointment Management</title> 
    <style> 
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f4f4f4; 
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
            width: 80%; 
            margin: auto; 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
            margin-top: 20px; 
        } 
        h1, h2 { 
            text-align: center; 
            color: #333; 
        } 
        p { 
            color: #555; 
            line-height: 1.6; 
        } 
        ul { 
            padding-left: 20px; 
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
<br>
<div class="container"> 
        <h1>Privacy Policy</h1> 
        <p>Last Updated: [Insert Date]</p> 
 <br><br>
        <div> 
            <h2>1. Introduction</h2> <br>
            <p>We value your privacy and are committed to protecting your personal data. This 
Privacy Policy explains how we collect, use, and safeguard your information.</p> 
        </div> 
<br><br>
        <div> 
            <h2>2. Information We Collect</h2> 
            <p>We collect the following types of information:</p> 
            <ul> 
                <li>Personal Information (Name, Contact Details, etc.)</li> 
                <li>Medical Data (Symptoms, Appointment Requests, etc.)</li> 
                <li>Login Credentials</li> 
                <li>Payment Information (for transactions)</li> 
            </ul> 
        </div> 
 <br>
        <div> 
            <h2>3. How We Use Your Information</h2> 
            <p>Your information is used for:</p> 
            <ul> 
                <li>Providing and improving our services</li> 
                <li>Connecting patients with doctors</li> 
                <li>Processing payments</li> 
                <li>Ensuring security and fraud prevention</li> 
            </ul> 
        </div> 
<br> 
        <div> 
            <h2>4. Data Protection</h2> <br>
            <p>We take security seriously and implement industry-standard measures to protect 
your data from unauthorized access or misuse.</p> 
        </div> 
<br><br>
        <div> 
            <h2>5. Sharing of Information</h2> <br>
            <p>We do not sell or rent your data. However, we may share your information with:</p> 
            <ul> 
                <li>Doctors for appointment scheduling</li> 
                <li>Payment processors for transactions</li> 
                <li>Legal authorities if required by law</li> 
            </ul> 
        </div> 
<br>
        <div> 
            <h2>6. Your Rights</h2> 
            <p>You have the right to:</p> 
            <ul> 
                <li>Access your data</li> 
                <li>Request data deletion</li> 
                <li>Update or correct your personal details</li> 
            </ul> 
        </div> 
<br> 
        <div> 
            <h2>7. Contact Us</h2> 
            <p>If you have any concerns regarding your privacy, you can contact us at:</p> 
            <ul> 
                <li>Email: vrushilmakwana@gmail.com</li> 
                <li>Phone: +91 63569 11912</li> 
            </ul> 
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