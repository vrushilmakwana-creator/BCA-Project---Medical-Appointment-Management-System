<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>FAQs - Medical Appointment Management</title> 
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
        h1 { 
            text-align: center; 
            color: #333; 
        } 
        .faq { 
            margin-bottom: 20px; 
            border-bottom: 1px solid #ddd; 
            padding-bottom: 10px; 
        } 
        .faq h3 { 
            color: #0275d8; 
            cursor: pointer; 
        } 
        .faq p { 
            display: none; 
            color: #555; 
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
    <script> 
        function toggleFAQ(id) { 
            var answer = document.getElementById(id); 
            if (answer.style.display === "none") { 
                answer.style.display = "block"; 
            } else { 
                answer.style.display = "none"; 
            } 
        } 
     </script> 
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

<div class="container"> 
        <h1>Frequently Asked Questions (FAQs)</h1> <br>
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q1')">1. What is this website for?</h3> 
            <p id="q1">This website helps patients find doctors based on their symptoms and book 
appointments easily.</p> 
        </div> 
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q2')">2. How does the symptom quiz work?</h3> 
            <p id="q2">The quiz analyzes your symptoms and suggests the most suitable doctors 
for your condition.</p> 
        </div> 
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q3')">3. Is this website free to use?</h3> 
            <p id="q3">Yes, you can create an account and search for doctors for free, but 
consultation fees may apply.</p> 
        </div> 
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q4')">4. How do I book an appointment?</h3> 
            <p id="q4">After logging in, take the symptom quiz, select a doctor, and request an 
appointment. The doctor will confirm it and provide payment details.</p> 
        </div> 
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q5')">5. Can I cancel or reschedule an appointment?</h3> 
            <p id="q5">Yes, but it depends on the doctor's cancellation and rescheduling policy.</p> 
        </div> 
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q6')">6. How can I contact my doctor?</h3> 
            <p id="q6">Once your appointment is confirmed, the doctor's contact details will be 
shared with you.</p> 
        </div> 
 
        <div class="faq"> 
            <h3 onclick="toggleFAQ('q7')">7. What if I can’t find a doctor for my condition?</h3> 
            <p id="q7">If no doctors are available, you can try refining your symptoms or check back 
later as new doctors are added regularly.</p> 
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