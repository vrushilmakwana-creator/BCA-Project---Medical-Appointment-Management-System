<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "medconnect";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
print_r($_SESSION);

// Get doctor's email from session
if (!isset($_SESSION['email'])) {
    die("Unauthorized access");
}
$doctor_email = $_SESSION['email'];

// Fetch daily routine from dprofile
$sql_routine = "SELECT start_time, end_time FROM dprofile WHERE email = ?";
$stmt = $conn->prepare($sql_routine);
$stmt->bind_param("s", $doctor_email);
$stmt->execute();
$routine_result = $stmt->get_result();
$routine = $routine_result->fetch_assoc();

// Get selected date from form (default to today)
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');

// Fetch time slots from schedules table
$sql_slots = "SELECT starting_time, ending_time, patient_name, description FROM schedules WHERE email = ? AND date = ?";
$stmt_slots = $conn->prepare($sql_slots);
$stmt_slots->bind_param("ss", $doctor_email, $selected_date);
$stmt_slots->execute();
$slots_result = $stmt_slots->get_result();

// Handle new slot submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_slots'])) {
    if (!empty($_POST['starting_time']) && !empty($_POST['ending_time']) && !empty($_POST['description'])) {
        $starting_time = $_POST['starting_time'];
        $ending_time = $_POST['ending_time'];
        $patient_name = $_POST['patient_name'] ?? "";
        $description = $_POST['description'];
        
        $insert_sql = "INSERT INTO schedules (email, date, starting_time, ending_time, patient_name, description) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_sql);
        $stmt_insert->bind_param("ssssss", $doctor_email, $selected_date, $starting_time, $ending_time, $patient_name, $description);
        $stmt_insert->execute();
        
        // Refresh to show new slot
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
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
            border-radius: 0 4px 5px 0;
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
            border-radius: 0px;
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
    </style>
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
    <script>
        function addEmptyRow() {
            let table = document.getElementById("scheduleTable");
            let newRow = table.insertRow();
            newRow.innerHTML = `<td><input type='time' name='starting_time'></td>
                                <td><input type='time' name='ending_time'></td>
                                <td><input type='text' name='patient_name' placeholder='Optional'></td>
                                <td><input type='text' name='description' required></td>
                                <td><button type='submit' name='save_slots'>Save</button></td>`;
        }
    </script>
</head>
<body>
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
        <a href="Doctor_home.php">Home</a>
        <a href="Request_page.php">Requests</a>
        <a href="Payment_interface.php">Payment</a>
        <a href="Doctor_profile.php">Profile</a>
    </nav><br><br>
    <h1><b><center>Time Slots</center></b></h1><br><br>
    <form method="POST" action="">
        <label for="selected_date">Date:</label>
        <input type="date" name="selected_date" value="<?php echo $selected_date; ?>">
        <button type="submit">Filter</button>
    </form><br>
    <form method="POST" action="">
        <table id="scheduleTable">
            <thead>
                <tr>
                    <th>Starting Time</th>
                    <th>Ending Time</th>
                    <th>Patient Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display daily routine as the default row
                if ($routine) {
                    echo "<tr><td>" . $routine["start_time"] . "</td><td>" . $routine["end_time"] . "</td><td></td><td>Daily Routine</td>";
                    echo "<td><button type='button' onclick='addEmptyRow()'>Add Slot</button></td></tr>";
                }
                
                // Display scheduled time slots
                if ($slots_result->num_rows > 0) {
                    while ($row = $slots_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["starting_time"] . "</td>";
                        echo "<td>" . $row["ending_time"] . "</td>";
                        echo "<td>" . ($row["patient_name"] ?: "") . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td><button type='button' onclick='addEmptyRow()'>Add Slot</button></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </form><br><br>
    <footer>
        <div>
            <a href="Help_doctor.php">Help</a>
            <a href="Privacy_policy_doctor.php">Privacy Policy</a>
            <a href="Contact_us_doctor.php">Contact Us</a>
            <a href="">Documentation</a>
            <a href="About_us_doctor.php">About Us</a>
            <a href="FAQ_doctor.php">FAQ</a>
        </div>
        <div>IG : vrushilmakwana</div>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
