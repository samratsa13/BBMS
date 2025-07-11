<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
    header('location:login.php');
    exit;
}

$id = '';
$row = [];
$nameErr = $ageErr = $genderErr = $addressErr = $contactErr = $diseaseErr = '';

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT * FROM req_history WHERE id='$id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $disease = isset($_POST['dis'])? mysqli_real_escape_string($con, $_POST['dis']): '';

    // Validate inputs
    $hasError = false;

    if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name) || preg_match("/^\s/", $name)) {
        $nameErr = 'Name can only contain letters, spaces, apostrophes, and hyphens, and cannot start with a space';
        $hasError = true;
    }
    if (empty($age) || !is_numeric($age) || $age <= 0 || $age > 120) {
        $ageErr = 'Valid age is required';
        $hasError = true;
    }
    if (empty($gender) || ($gender !== 'Male' && $gender !== 'Female')) {
        $genderErr = 'Gender is required';
        $hasError = true;
    }
    
    if (empty($address) || !preg_match("/^[a-zA-Z0-9\s,.'-]+$/", $address)) {
        $addressErr = 'Invalid address format';
        $hasError = true;
    }
    if (empty($contact) || !preg_match("/^9[87][0-9]{8}$/", $contact)) {
        $contactErr = 'Invalid contact number format';
        $hasError = true;
    }
    if (empty($disease) || !preg_match("/^[a-zA-Z\s]+$/", $disease)) {
        $diseaseErr = 'Invalid disease format';
        $hasError = true;
    }

    if (!$hasError) {
        $prev_query = "SELECT status FROM req_history WHERE id='$id'"; 
        $prev_result = mysqli_query($con, $prev_query); 
        $prev_row = mysqli_fetch_assoc($prev_result); 
        $prev_status = $prev_row['status'];




        $query = "UPDATE req_history SET name='$name', age='$age', gender='$gender', address='$address', contact='$contact', disease='$disease',status='$prev_status' WHERE id='$id'";
        if (mysqli_query($con, $query)) {
            header('location:req_his.php');
            exit;
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="reeqedit.css">
    <title>Edit Request</title>
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            const nameInput = form.querySelector("input[name='name']");
            const ageInput = form.querySelector("input[name='age']");
            const genderSelect = form.querySelector("select[name='gender']");
            const addressInput = form.querySelector("input[name='address']");
            const contactInput = form.querySelector("input[name='contact']");
            const diseaseInput = form.querySelector("input[name='disease']");

            nameInput.addEventListener("input", validateName);
            ageInput.addEventListener("input", validateAge);
            genderSelect.addEventListener("change", validateGender);
            addressInput.addEventListener("input", validateAddress);
            contactInput.addEventListener("input", validateContact);
            diseaseInput.addEventListener("input", validateDisease);

            function validateName() {
                const name = nameInput.value.trim();
                const regex = /^[a-zA-Z\s]+$/;  // Only letters and spaces
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
                if (isNaN(age) || age <= 0 || age > 120) {
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
                const regex = /^[a-zA-Z][a-zA-Z0-9,' -]*$/; // Address must start with a letter
                if (!address || !regex.test(address)) {
                    showError(addressInput, 'Address must start with a letter and contain only alphabets, numbers, spaces, commas, apostrophes, and hyphens.');
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
                const disease = diseaseInput.value.trim();
                const regex = /^[a-zA-Z\s]+$/;  // Only letters and spaces
                if (!disease || !regex.test(disease) || /^\s/.test(disease)) {
                    showError(diseaseInput, 'Disease information can only contain letters and spaces, and cannot start with a space.');
                    return false;
                } else {
                    hideError(diseaseInput);
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

            form.addEventListener("submit", function (event) {
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
        <h1>Edit Blood Request</h1>
        </div>
        <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">
        <h1>Name:</h1>
        <input type="text" name="name" id="hi" value="<?php echo $row['name'] ?? ''; ?>" required>
        <span class="error-msg" id="error">
            <?php echo $nameErr; ?>
        </span>

        <h1>Age:</h1>
        <input type="number" name="age" id="hi" value="<?php echo $row['age'] ?? ''; ?>" required>
        <span class="error-msg" id="error">
            <?php echo $ageErr; ?>
        </span>

        <h1>Gender:</h1>
        <select name="gender" id="hi" required>
            <option value="Male" <?php if(isset($row['gender']) && $row['gender']=='Male' ) echo 'selected' ; ?>>Male
            </option>
            <option value="Female" <?php if(isset($row['gender']) && $row['gender']=='Female' ) echo 'selected' ; ?>
                >Female</option>
        </select>
        <span class="error-msg" id="error">
            <?php echo $genderErr; ?>
        </span>

        <h1>Blood Group:</h1>
        <input type="text" name="blood_group" value="<?php echo htmlspecialchars($row['blood_group']); ?>" readonly>
        

        <h1>Blood Count:</h1>
        <input type="number" name="bloodcount" id="hi" value="<?php echo $row['bloodcount'] ?? ''; ?>" readonly>
        

        <h1>Address:</h1>
        <input type="text" name="address" id="hi" value="<?php echo $row['address'] ?? ''; ?>" required>
        <span class="error-msg" id="error">
            <?php echo $addressErr; ?>
        </span>

        <h1>Mobile Number:</h1>
        <input type="text" name="contact" id="hi" value="<?php echo $row['contact'] ?? ''; ?>" required>
        <span class="error-msg" id="error">
            <?php echo $contactErr; ?>
        </span>

        <div class="disease">
            <h1>Disease:</h1>
            <select name="dis" id="hi" required>
                <option value="Nothing" <?php if($row['disease']=='Nothing' ) echo 'selected' ; ?>>Nothing</option>
                <option value="Fever" <?php if($row['disease']=='Fever' ) echo 'selected' ; ?>>Fever</option>
                <option value="Common Cold" <?php if($row['disease']=='Common Cold' ) echo 'selected' ; ?>>Common Cold</option>
                <option value="Dengue" <?php if($row['disease']=='Dengue' ) echo 'selected' ; ?>>Dengue</option>
                <option value="Cholera" <?php if($row['disease']=='Cholera' ) echo 'selected' ; ?>>Cholera</option>
                <option value="Tuberculosis" <?php if($row['disease']=='Tuberculosis' ) echo 'selected' ; ?>>Tuberculosis</option>
                <option value="Cancer" <?php if($row['disease']=='Cancer' ) echo 'selected' ; ?>>Cancer</option>
                <option value="Others" <?php if($row['disease']=='Others' ) echo 'selected' ; ?>>Others</option>
            </select>
            <span class="error-msg"></span>
        </div>

        <input type="submit" name="update" value="Update" id="update">
        </form>
    </div>
</body>
</html>