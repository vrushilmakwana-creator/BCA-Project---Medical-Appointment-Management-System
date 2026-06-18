<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
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
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 15px;
        }
        .btn:hover {
            background-color: #45a049;
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
        
        * {
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
    
    <br><br><br>
    <b><center><u><h1>Doctor Categories</h1></u></center></b>
    <br> <br>

    <div class="doctor-list">
        <div class="doctor-card">
            <div class="doctor-photo">
                <img src="doctor1.jpg" alt="Doctor">
            </div>
            <div class="doctor-info">
                <h3>Dr. Aditi Sharma (Cardiologist)</h3>
                <p><b>Fees:</b> ₹800</p>
                <p><b>Address:</b> Apollo Hospital, Ahmedabad</p>
                <p><b>Time Slot:</b> 10:00 AM - 12:00 PM</p>
            </div>
            <button class="btn">Apply</button>
        </div>

        <div class="doctor-card">
            <div class="doctor-photo">
                <img src="doctor2.jpg" alt="Doctor">
            </div>
            <div class="doctor-info">
                <h3>Dr. Raj Mehta (Dermatologist)</h3>
                <p><b>Fees:</b> ₹600</p>
                <p><b>Address:</b> Skin Care Clinic, Vadodara</p>
                <p><b>Time Slot:</b> 1:00 PM - 3:00 PM</p>
            </div>
            <button class="btn">Apply</button>
        </div>

        <div class="doctor-card">
            <div class="doctor-photo">
                <img src="doctor3.jpg" alt="Doctor">
            </div>
            <div class="doctor-info">
                <h3>Dr. Sneha Patel (Neurologist)</h3>
                <p><b>Fees:</b> ₹1,200</p>
                <p><b>Address:</b> Neuro Care Center, Surat</p>
                <p><b>Time Slot:</b> 2:00 PM - 4:00 PM</p>
            </div>
            <button class="btn">Apply</button>
        </div>

        <div class="doctor-card">
            <div class="doctor-photo">
                <img src="doctor4.jpg" alt="Doctor">
            </div>
            <div class="doctor-info">
                <h3>Dr. Vinay Joshi (Orthopedic)</h3>
                <p><b>Fees:</b> ₹900</p>
                <p><b>Address:</b> Sunshine Hospital, Rajkot</p>
                <p><b>Time Slot:</b> 4:00 PM - 6:00 PM</p>
            </div>
            <button class="btn">Apply</button>
        </div>
    </div>

    <br>
    <footer>
        <div>
            <a href="Help_232.php">Help</a>
            <a href="Privacy_policy_232.php">Privacy Policy</a>
            <a href="Contact_us.php">Contact Us</a>
            <a href="">Documentation</a>
            <a href="About_us.php">About Us</a>
            <a href="FAQ_232.php">FAQ</a>
            <a href="#">FAQ</a>
        </div>
        <div>IG : vrushilmakwana</div>
    </footer>
</body>
</html>