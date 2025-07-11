<?php

@include 'config.php';
session_start();

var_dump($_SESSION);
$user_id = $_SESSION['user_id'];

$nameErr = $ageErr = $genderErr = $bloodgroupErr = $bloodcountErr = $addressErr = $contactErr = $diseaseErr = "";
$name = $age = $gender = $bloodgroup = $bloodcount = $address = $contact = $disease = "";
$success="";

if (!isset($_SESSION['user_name'])){
    header('location:loginn.php');
}
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : '';
    $bloodgroup = isset($_POST['blood_group']) ? mysqli_real_escape_string($con, $_POST['blood_group']) : '';
    $bloodcount = mysqli_real_escape_string($con, $_POST['bloodcount']);
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $disease = isset($_POST['dis'])? mysqli_real_escape_string($con, $_POST['dis']): '';
    

    // Validate inputs
    if (empty($name)) {
        $nameErr = 'Name is required';
    }
    if (!preg_match("/^[a-zA-Z' -]+$/", $name) || preg_match("/^\s/", $_POST['name'])) {
        $nameErr = 'Name can only contain letters, spaces, apostrophes, and hyphens, and cannot start with a space'; 
    }
    if (empty($age) || !is_numeric($age) || $age <= 0 || $age>100) {
        $ageErr = 'Valid age is required';
    }
    if (empty($gender)) {
        $genderErr = 'Gender is required';
    }
    if (empty($bloodgroup)) {
        $bloodgroupErr = 'Blood group is required';
    }
    if (empty($bloodcount) || !is_numeric($bloodcount) || $bloodcount <= 0) {
        $bloodcountErr = 'Valid blood count is required';
    }
    if (empty($address)) {
        $addressErr = 'Address is required';
    }
    if (!preg_match("/^[a-zA-Z0-9,' -]+$/", $address)){
        $addressErr = 'Only alphabets';
    }
    if (empty($contact) || !is_numeric($contact)) {
        $contactErr = 'Valid contact number is required';
    }
    if (!preg_match("/^9[87][0-9]{8}$/", $contact)) {
        $contactErr = 'Invalid contact number format'; 
    }
   
    
    if (!preg_match("/^[a-zA-Z' -]+$/", $name) || preg_match("/^\s/", $_POST['name'])) {
        $diseaseErr = 'Invalid';
    }
    if (empty($nameErr) && empty($ageErr) && empty($genderErr) && empty($bloodgroupErr) && empty($bloodcountErr) && empty($addressErr) && empty($contactErr) && empty($diseaseErr)) {
        echo "Debug: User ID = $user_id";
        $query = "INSERT INTO don_history (name, age, gender, blood_group, bloodcount, address, contact, disease,user_id) VALUES ('$name', '$age', '$gender', '$bloodgroup', '$bloodcount', '$address', '$contact', '$disease','$user_id')";
        if (mysqli_query($con, $query)) {
            $success= "Donation request submitted successfully!";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }
}
$diseaseSelected = isset($_POST['disease']) ? $_POST['disease'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="donateee.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const nameInput = form.querySelector("input[name='name']");
    const ageInput = form.querySelector("input[name='age']");
    const genderSelect = form.querySelector("select[name='gender']");
    const bloodGroupSelect = form.querySelector("select[name='blood_group']");
    const bloodCountInput = form.querySelector("input[name='bloodcount']");
    const addressInput = form.querySelector("input[name='address']");
    const contactInput = form.querySelector("input[name='contact']");
    const diseaseSelect = form.querySelector("select[name='dis']");

    nameInput.addEventListener("input", validateName);
    ageInput.addEventListener("input", validateAge);
    genderSelect.addEventListener("change", validateGender);
    bloodGroupSelect.addEventListener("change", validateBloodGroup);
    bloodCountInput.addEventListener("input", validateBloodCount);
    addressInput.addEventListener("input", validateAddress);
    contactInput.addEventListener("input", validateContact);
    diseaseSelect.addEventListener("change", validateDisease);

    function validateName() {
        const name = nameInput.value.trim();
        const regex = /^[a-zA-Z ]+$/;
        if (!name || !regex.test(name) || /^\s/.test(name)) {
            showError(nameInput, 'Name can only contain letters, spaces, apostrophes, and hyphens, and cannot start with a space.');
        } else {
            hideError(nameInput);
        }
    }

    function validateAge() {
        const age = parseInt(ageInput.value, 10);
        if (isNaN(age) || age <= 0 || age > 100) {
            showError(ageInput, 'Valid age is required.');
        } else {
            hideError(ageInput);
        }
    }

    function validateGender() {
        if (!genderSelect.value) {
            showError(genderSelect, 'Gender is required.');
        } else {
            hideError(genderSelect);
        }
    }

    function validateBloodGroup() {
        if (!bloodGroupSelect.value) {
            showError(bloodGroupSelect, 'Blood group is required.');
        } else {
            hideError(bloodGroupSelect);
        }
    }

    function validateBloodCount() {
        const bloodCount = parseFloat(bloodCountInput.value);
        if (isNaN(bloodCount) || bloodCount <= 0) {
            showError(bloodCountInput, 'Valid blood count is required.');
        } else {
            hideError(bloodCountInput);
        }
    }

    function validateAddress() {
        const address = addressInput.value.trim();
        const regex = /^[a-zA-Z0-9,' -]+$/;
        if (!address || !regex.test(address)) {
            showError(addressInput, 'Address is required and must contain only alphabets, numbers, spaces, commas, apostrophes, and hyphens.');
        } else {
            hideError(addressInput);
        }
    }

    function validateContact() {
        const contact = contactInput.value.trim();
        const regex = /^9[87][0-9]{8}$/;
        if (!contact || !regex.test(contact)) {
            showError(contactInput, 'Invalid contact number format.');
        } else {
            hideError(contactInput);
        }
    }

    function validateDisease() {
        if (!diseaseSelect.value) {
            showError(diseaseSelect, 'Please select a disease.');
        } else {
            hideError(diseaseSelect);
        }
    }

    function showError(input, message) {
        const errorElement = input.nextElementSibling;
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function hideError(input) {
        const errorElement = input.nextElementSibling;
        errorElement.style.display = 'none';
    }
});

    </script>
</head>

<body>
    <header>
    <nav>
        <ul>
            <li><a href="donate.php">Donate</a></li>
            <li><a href="request.php">Request</a></li>
            <li><a href="req_his.php">Request History</a></li>
            <li><a href="don_his.php">Donation History</a></li>
        </ul>
        <a href="userr.php">
            <div class="im"><img src="final.png" alt=""></div>
        </a>
        <h2>Hi<span>&nbsp;<?php echo $_SESSION['user_name']?></span></h2>
        <a href="logout.php"><h4>LOGOUT</h4></a>
    </nav>
</header>

    
    <img src="don.png" alt="">
    <div class="form-container">
        <form action="" method="post">
            <h1>Donate Blood</h1>
            <input type="text" name="name" required placeholder="Enter your name">
            <span class="error-msg">
                <?php echo $nameErr; ?>
            </span>
            <input type="number" id="age" name="age" required placeholder="Enter your age">
            <span class="error-msg">
                <?php echo $ageErr; ?>
            </span>
            <div class="gen">
                <h3>Gender:</h3>
                <select name="gender" id="">
                    <option>Male</option>
                    <option>Female</option>
                </select>
                <span class="error-msg">
                    <?php echo $genderErr; ?>
                </span>
            </div>
            <div class="bg">
                <h3>Blood Group:</h3>
                <select name="blood_group" id="">
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                    <option>O+</option>
                    <option>O-</option>
                </select>
                <span class="error-msg">
                    <?php echo $bloodgroupErr; ?>
                </span>
            </div>
            <br><br>
            <input type="number" name="bloodcount" required placeholder="Amount of blood (in pints)">
            <span class="error-msg">
                <?php echo $bloodcountErr; ?>
            </span>
            <input type="text" name="address" required placeholder="Enter your address">
            <span class="error-msg">
                <?php echo $addressErr; ?>
            </span>
            <input type="number" name="contact" required placeholder="Mobile number">
            <span class="error-msg">
                <?php echo $contactErr; ?>
            </span>
            
            <div class="disease">
                <h3>Mention your disease:</h3>
                <select name="dis" id="">
                    <option>Nothing</option>
                    <option>Fever</option>
                    <option>Common Cold</option>
                    <option>Dengue</option>
                    <option>Cholera</option>
                    <option>Tuberculosis</option>
                    <option>Cancer</option>
                    <option>Others</option>

                </select>
                
            </div>

            <input type="submit" name="submit" value="Donate Now" class="form-btn">
            <input type="reset" value="Reset" class="form-reset">
            <span class="success-msg">
                <?php echo $success; ?>
                <br><br><br>
        </form>

    </div>
    </div>
</body>

</html>