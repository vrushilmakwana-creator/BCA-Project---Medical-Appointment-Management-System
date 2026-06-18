
<!DOCTYPE html>
<html>
<head>
    <title>Request Appointment</title>
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
table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
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
<center><h1>Request Appointment</h1></center>>
    <form method="post">
        <label>Appointment Date:</label>
        <input type="date" name="appointment_date" required><br>

        <label>Appointment Time:</label>
        <input type="time" name="appointment_time" required><br>

        <label>Symptoms:</label>
        <select name="symptom">
            <option value="Fever">Fever</option>
            <option value="Cough">Cough</option>
            <option value="Headache">Headache</option>
            <option value="Stomach Pain">Stomach Pain</option>
            <option value="Skin Rash">Skin Rash</option>
            <option value="Joint Pain">Joint Pain</option>
        </select>

        <label>Other Symptoms (Optional):</label>
        <input type="text" name="custom_symptom" placeholder="Describe your symptoms"><br>

        <label>How long have you had these symptoms?</label>
        <select name="duration">
            <option value="Less than 24 hours">Less than 24 hours</option>
            <option value="1-3 days">1-3 days</option>
            <option value="4-7 days">4-7 days</option>
            <option value="More than a week">More than a week</option>
        </select><br>

        <label>How severe are your symptoms?</label>
        <select name="severity">
            <option value="Mild">Mild (manageable discomfort)</option>
            <option value="Moderate">Moderate (affecting daily activities)</option>
            <option value="Severe">Severe (requires immediate attention)</option>
        </select><br>

        <label>Do you have any existing medical conditions? (Select all that apply)</label><br>
        <input type="checkbox" name="conditions[]" value="Diabetes"> Diabetes<br>
        <input type="checkbox" name="conditions[]" value="Hypertension"> Hypertension<br>
        <input type="checkbox" name="conditions[]" value="Heart Disease"> Heart Disease<br>
        <input type="checkbox" name="conditions[]" value="Asthma"> Asthma<br>
        <input type="checkbox" name="conditions[]" value="None"> None<br>

        <label>Have you recently traveled?</label><br>
        <input type="radio" name="travel" value="Yes"> Yes<br>
        <input type="radio" name="travel" value="No"> No<br>

        <label>Do you have any known allergies to medications?</label><br>
        <input type="radio" name="allergies" value="Yes"> Yes<br>
        <input type="radio" name="allergies" value="No"> No<br>

        <label>If yes, please specify:</label>
        <input type="text" name="allergy_details" placeholder="Describe allergies"><br>

        <label>Location:</label>
        <input type="text" name="location" placeholder="City or Area"><br>

        <label>Preferred Appointment Days:</label><br>
        <input type="checkbox" name="days[]" value="Monday"> Monday<br>
        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday<br>
        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday<br>
        <input type="checkbox" name="days[]" value="Thursday"> Thursday<br>
        <input type="checkbox" name="days[]" value="Friday"> Friday<br>
        <input type="checkbox" name="days[]" value="Saturday"> Saturday<br>

        <input type="submit" value="Submit Request">
    </form>
</body>
</html>
