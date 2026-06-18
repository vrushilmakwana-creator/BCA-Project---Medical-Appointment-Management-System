<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection
$servername = "localhost"; 
$username = "root";
$password = "";
$database = "medconnect"; 

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search results
$result = null;

// Check if search query is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['query'])) {
    $search = trim($_POST['query']);
    
    // Split the search term into individual words
    $keywords = explode(" ", $search);
    
    // Build dynamic SQL query for name search using prepared statements
    $queryConditions = [];
    $params = [];
    $types = "";

    foreach ($keywords as $word) {
        $queryConditions[] = "(DfirstName LIKE ? OR DmiddleName LIKE ? OR DlastName LIKE ?)";
        $wordParam = "%$word%";
        array_push($params, $wordParam, $wordParam, $wordParam);
        $types .= "sss";
    }
    
    // Combine conditions
    $nameQuery = implode(" OR ", $queryConditions);
    $sql = "SELECT * FROM dprofile WHERE ($nameQuery) OR Specialization LIKE ? OR Dcity LIKE ?";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $searchParam = "%$search%";
        array_push($params, $searchParam, $searchParam);
        $types .= "ss";

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
        body {
            font-family: Arial, sans-serif;
        }
        /* Doctor List Styling */
        .doctor-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 20px;
        }
        .doctor-card {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }
        .doctor-photo {
            background: #f0f0f0;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .doctor-photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .doctor-info {
            flex-grow: 1;
            padding: 15px;
            background: white;
        }
        .doctor-info h3 {
            margin: 5px 0;
            color: #333;
        }
        .doctor-info p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }
        button[type="submit"] {
            margin-top: 18px;
            padding: 10px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #007bff;
            text-decoration: none;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 20px;
            margin-top: 2px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-right: 25px;
        }
        .btn:hover {
            background-color: #007bff;
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
        
        .logo {
            max-width: 160px;
            height: auto;
            display: block;
            margin: 10px;
        }
        input[type="btn"] {
            margin-top: 13px;
            padding: 7px;
            font-size: 17px;
            color: white;
            background-color: #007bff;
            border: none;
            width: 58%;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="btn"]:hover {
            background-color: #007bff;
            /*            text-decoration: underline;*/
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
            border: none;
            padding: 7px;
            margin-top: 0;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
            font-size: 18px;
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
<br><br>
    <h2 style="text-align:center;">Search Results</h2>
    <div class="doctor-list">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $got_email = htmlspecialchars($row['email']); // Store email securely
                echo "<div class='doctor-card'>";
                echo "<div class='doctor-photo'>";
                echo "<img src='" . ($row['DprofilePic'] ? htmlspecialchars($row['DprofilePic']) : "default-profile.png") . "' alt='Doctor Profile'>";
                echo "</div>";
                echo "<div class='doctor-info'>";
                echo "<h3>Dr. " . htmlspecialchars($row['DfirstName'] . " " . $row['DmiddleName'] . " " . $row['DlastName']) . "</h3>";
                echo "<p>Specialization: " . htmlspecialchars($row['Specialization']) . "</p>";
                echo "<p>City: " . htmlspecialchars($row['Dcity']) . "</p>";
                echo "<p>Fees: ₹" . htmlspecialchars($row['Dfees']) . "</p>";
                echo "</div>";
                
                // Visit Profile Button
                echo "<div><a href='Visit_Doctor_profile.php?email=$got_email'><button class='btn'>Visit Profile</button></a></div>";
                
                echo "</div>";
            }
        } else {
            echo "<p class='no-results'>No doctors found matching your search.</p>";
        }
        ?>
    </div>
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
