<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
    header('location:login.php');
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM don_history WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $disease = isset($_POST['dis'])? mysqli_real_escape_string($con, $_POST['dis']): '';

    $prev_query = "SELECT status FROM don_history WHERE id='$id'"; 
    $prev_result = mysqli_query($con, $prev_query); 
    $prev_row = mysqli_fetch_assoc($prev_result); 
    $prev_status = $prev_row['status'];

    $query = "UPDATE don_history SET name='$name', age='$age', gender='$gender', address='$address', contact='$contact', disease='$disease', status='$prev_status' WHERE id='$id'";

    if (mysqli_query($con, $query)) {
        header('location:don_his.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="doneedit.css">
    <title>Edit Request</title>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const nameInput = form.querySelector("input[name='name']");
    const ageInput = form.querySelector("input[name='age']");
    const genderSelect = form.querySelector("select[name='gender']");
    const addressInput = form.querySelector("input[name='address']");
    const contactInput = form.querySelector("input[name='contact']");
    const diseaseSelect = form.querySelector("select[name='dis']");

    nameInput.addEventListener("input", validateName);
    ageInput.addEventListener("input", validateAge);
    genderSelect.addEventListener("change", validateGender);
    addressInput.addEventListener("input", validateAddress);
    contactInput.addEventListener("input", validateContact);
    diseaseSelect.addEventListener("change", validateDisease);

    function validateName() {
        const name = nameInput.value.trim();
        const regex = /^[a-zA-Z ]+$/;  // Only letters and spaces
        if (!name || !regex.test(name) || /^\s/.test(nameInput.value)) {
            showError(nameInput, 'Name can only contain letters and spaces, and cannot start with a space.');
            return false;
        } else {
            hideError(nameInput);
            return true;
        }
    }

    function validateAge() {
        const age = parseInt(ageInput.value, 10);
        if (isNaN(age) || age <= 0 || age > 100) {
            showError(ageInput, 'Valid age is required.');
            return false;
        } else {
            hideError(ageInput);
            return true;
        }
    }

    function validateGender() {
        if (!genderSelect.value) {
            showError(genderSelect, 'Gender is required.');
            return false;
        } else {
            hideError(genderSelect);
            return true;
        }
    }


    function validateAddress() {
        const address = addressInput.value.trim();
        const regex = /^[a-zA-Z0-9,' -]+$/;
        if (!address || !regex.test(address)|| /^\s/.test(addressInput.value)) {
            showError(addressInput, 'Address must contain only alphabets, numbers, spaces, commas, apostrophes, and hyphens.');
            return false;
        } else {
            hideError(addressInput);
            return true;
        }
    }

    function validateContact() {
        const contact = contactInput.value.trim();
        const regex = /^9[87][0-9]{8}$/;
        if (!contact || !regex.test(contact)) {
            showError(contactInput, 'Invalid contact number format.');
            return false;
        } else {
            hideError(contactInput);
            return true;
        }
    }

    function validateDisease() {
        if (!diseaseSelect.value) {
            showError(diseaseSelect, 'Please select a disease.');
            return false;
        } else {
            hideError(diseaseSelect);
            return true;
        }
    }

    function showError(input, message) {
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('error-msg')) {
            errorElement = document.createElement('span');
            errorElement.classList.add('error-msg');
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function hideError(input) {
        const errorElement = input.nextElementSibling;
        if (errorElement && errorElement.classList.contains('error-msg')) {
            errorElement.style.display = 'none';
        }
    }

    form.addEventListener("submit", function(event) {
        const isNameValid = validateName();
        const isAgeValid = validateAge();
        const isGenderValid = validateGender();
        const isAddressValid = validateAddress();
        const isContactValid = validateContact();
        const isDiseaseValid = validateDisease();

        if (!isNameValid || !isAgeValid || !isGenderValid || !isAddressValid || !isContactValid || !isDiseaseValid) {
            event.preventDefault();
        }
    });
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
   
            <a href="userr.php"><img src="final.png" alt=""></a>
            <h2>Hi<span>&nbsp;
                    <?php echo $_SESSION['user_name']?>
                </span></h2>
            
           
            <a href="logout.php"><h4>LOGOUT</h4></a>
        </nav>
    </header>
    <div class="head">
        <h1>Edit Donor Request</h1>
    </div>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> 
        <h1>Name:</h1> 
        <input type="text" name="name" id="hi" value="<?php echo $row['name']; ?>" required> 
        <span class="error-msg"></span> 
        <h1>Age:</h1> 
        <input type="number" name="age" id="hi" value="<?php echo $row['age']; ?>" required> 
        <span class="error-msg"></span> 
        <h1>Gender:</h1> 
        <select name="gender" id="hi" required> 
            <option value="Male" <?php if($row['gender'] == 'Male') echo 'selected'; ?>>Male</option> 
            <option value="Female" <?php if($row['gender'] == 'Female') echo 'selected'; ?>>Female</option> 
        </select> 
        <span class="error-msg"></span> 
        <h1>Blood Group:</h1>
        <input type="text" name="blood_group" value="<?php echo htmlspecialchars($row['blood_group']); ?>" readonly>
      
                
        <h1>Blood Count:</h1>
        <input type="number" name="bloodcount" id="hi" value="<?php echo $row['bloodcount'] ?? ''; ?>" readonly>
        
        <h1>Address:</h1> 
        <input type="text" name="address" id="hi" value="<?php echo $row['address']; ?>" required> 
        <span class="error-msg"></span> 
        <h1>Contact:</h1> 
        <input type="text" name="contact" id="hi" value="<?php echo $row['contact']; ?>" required> 
        <span class="error-msg"></span>
        <div class="disease"> 
            <h1>Disease:</h1>
            <select name="dis" id="hi" required> 
                <option value="Nothing" <?php if($row['disease'] == 'Nothing') echo 'selected'; ?>>Nothing</option> 
                <option value="Fever" <?php if($row['disease'] == 'Fever') echo 'selected'; ?>>Fever</option> 
                <option value="Common Cold" <?php if($row['disease'] == 'Common Cold') echo 'selected'; ?>>Common Cold</option> 
                <option value="Dengue" <?php if($row['disease'] == 'Dengue') echo 'selected'; ?>>Dengue</option> 
                <option value="Cholera" <?php if($row['disease'] == 'Cholera') echo 'selected'; ?>>Cholera</option> 
                <option value="Tuberculosis" <?php if($row['disease'] == 'Tuberculosis') echo 'selected'; ?>>Tuberculosis</option> 
                <option value="Cancer" <?php if($row['disease'] == 'Cancer') echo 'selected'; ?>>Cancer</option> 
                <option value="Others" <?php if($row['disease'] == 'Others') echo 'selected'; ?>>Others</option> 
            </select> 
            <span class="error-msg"></span>
        </div>
        
        <input type="submit" name="update" value="Update" id="update">
    </form>
</body>
</html>
