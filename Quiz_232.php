<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>Medical Quiz</title> 
  <style> 
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
            margin-top: 6px;
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
    }.container { 
      max-width: 600px; 
      margin: 40px auto; 
      background: #fff; 
      padding: 20px 30px; 
      border-radius: 8px; 
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
    } 
    h2 { 
      text-align: center; 
      color: #333; 
    } 
    label { 
      font-weight: bold; 
      display: block; 
      margin: 15px 0 5px; 
    } 
    input[type="text"], 
    select, 
    textarea { 
      width: 100%; 
      padding: 10px; 
      margin-top: 5px; 
      border: 1px solid #ccc; 
      border-radius: 4px; 
      box-sizing: border-box; 
    } 
    input[type="checkbox"], 
    input[type="radio"] { 
      margin-right: 5px; 
    } 
    .question { 
      margin-bottom: 20px; 
    } 
    .submit-btn { 
      width: 100%; 
      padding: 12px; 
      background: #007BFF; 
      border: none; 
      color: #fff; 
      font-size: 16px; 
      border-radius: 4px; 
      cursor: pointer; 
    } 
    .submit-btn:hover { 
      background: #0056b3; 
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
      background: #f9f9f9; 
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
  <div class="container"> 
    <u><h2>Medical Symptom Quiz</h2></u> <br>
    <form action="process_quiz.php" method="POST"> 
 <br>
      <!-- Question 1 --> 
      <div class="question"> 
        <label>1. What are your primary symptoms? (Select all that apply)</label>
        <input type="checkbox" name="symptoms[]" value="Fever"> Fever<br> 
        <input type="checkbox" name="symptoms[]" value="Cough"> Cough<br> 
        <input type="checkbox" name="symptoms[]" value="Headache"> Headache<br> 
        <input type="checkbox" name="symptoms[]" value="Stomach Pain"> Stomach Pain<br> 
        <input type="checkbox" name="symptoms[]" value="Skin Rash"> Skin Rash<br> 
        <input type="checkbox" name="symptoms[]" value="Joint Pain"> Joint Pain<br> 
        <input type="text" name="other_symptom" placeholder="Other (please specify)"> 
      </div> 
 <br>
      <!-- Question 2 --> 
      <div class="question"> 
        <label>2. How long have you been experiencing these symptoms?</label>
        <select name="duration"> 
          <option value="Less than 24 hours">Less than 24 hours</option> 
          <option value="1-3 days">1-3 days</option> 
          <option value="4-7 days">4-7 days</option> 
          <option value="More than a week">More than a week</option> 
        </select> 
      </div> 
 <br>
      <!-- Question 3 --> 
      <div class="question"> 
        <label>3. How severe are your symptoms?</label> 
        <select name="severity"> 
          <option value="Mild">Mild (manageable discomfort)</option> 
          <option value="Moderate">Moderate (affecting daily activities)</option> 
          <option value="Severe">Severe (requires immediate attention)</option> 
        </select> 
      </div> 
 <br>
      <!-- Question 4 --> 
      <div class="question"> 
        <label>4. Do you have any existing medical conditions? (Select all that apply)</label>
        <input type="checkbox" name="conditions[]" value="Diabetes"> Diabetes<br> 
        <input type="checkbox" name="conditions[]" value="Hypertension"> Hypertension<br> 
        <input type="checkbox" name="conditions[]" value="Heart Disease"> Heart Disease<br> 
        <input type="checkbox" name="conditions[]" value="Asthma"> Asthma<br> 
        <input type="checkbox" name="conditions[]" value="None"> None 
      </div> 
 <br>
      <!-- Question 5 --> 
      <div class="question"> 
        <label>5. Have you recently traveled to a different city or country?</label><br>        
        <input type="radio" name="travel" value="Yes" id="travelYes"> 
        <label for="travelYes" style="display:inline;">Yes</label> 
        <input type="radio" name="travel" value="No" id="travelNo"> 
        <label for="travelNo" style="display:inline;">No</label> 
      </div> 
 <br>
      <!-- Question 6 --> 
      <div class="question"> 
        <label>6. Do you have any known allergies to medications?</label><br>
        <input type="radio" name="allergies" value="Yes" id="allergyYes"> 
        <label for="allergyYes" style="display:inline;">Yes</label> 
        <input type="radio" name="allergies" value="No" id="allergyNo"> 
        <label for="allergyNo" style="display:inline;">No</label> <br>
        <input type="text" name="allergy_details" placeholder="If yes, please specify"> 
      </div> 
 <br>
      <!-- Question 7 --> 
      <div class="question"> 
        <label>7. Please enter your city or area for location-based doctor 
recommendations:</label>
        <input type="text" name="location" placeholder="City or Area"> <br>
      </div> 
 <br>
      <!-- Question 8 --> 
      <div class="question"> 
        <label>8. What day of the week do you prefer for the appointment?</label>
        <input type="checkbox" name="days[]" value="Monday"> Monday <br>
        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday <br>
        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday <br>
        <input type="checkbox" name="days[]" value="Thursday"> Thursday <br>
        <input type="checkbox" name="days[]" value="Friday"> Friday <br>
        <input type="checkbox" name="days[]" value="Saturday"> Saturday <br>  
      </div> 
 
      <center><button type="submit" class="submit-btn">Submit Quiz</button></center> 
    </form> 
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