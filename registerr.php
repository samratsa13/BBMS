<?php
include 'config.php';

$NameError = $EmailError = $PasswordError = $CpasswordError = "";
$Name = $Email = $Password = $Cpassword = "";

if (isset($_POST['submit'])) {
    $Name = mysqli_real_escape_string($con, trim($_POST['name']));
    $Email = mysqli_real_escape_string($con, $_POST['email']);
    $Password = md5($_POST['password']);
    $Cpassword = md5($_POST['cpassword']);
    $user_type = 'user';

    // Validate name to ensure no leading spaces and valid characters
    if (!preg_match("/^[a-zA-Z' -]+$/", $Name) || preg_match("/^\s/", $_POST['name'])) {
        $NameError = 'Name can only contain letters, spaces, apostrophes, and hyphens, and cannot start with a space'; 
    }
    
    // Validate email
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9._-]*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/", $Email)) {
        $EmailError = 'Email must start with a letter, contain only letters, numbers, dots, underscores, and hyphens, and follow the format: name@domain.com'; 
    }

    // Validate password matching
    if ($Password != $Cpassword) {
        $CpasswordError = 'Password did not match';
    } else {
        // Additional password checks
        if (strlen($_POST['password']) < 8) {
            $PasswordError = 'Password must be at least 8 characters long';
        }
        if (!preg_match('/[0-9]/', $_POST['password'])) {
            $PasswordError = 'Password must contain at least one number';
        }
        if (preg_match('/^ /', $_POST['password'])) {
            $PasswordError = 'Password cannot start with a space';
        }
    }

    // If no errors, proceed with database insertion
    if (empty($NameError) && empty($EmailError) && empty($PasswordError) && empty($CpasswordError)) {
        $select = "SELECT * FROM userr_form WHERE Email='$Email' AND Password='$Password'";
        $result = mysqli_query($con, $select);

        if (mysqli_num_rows($result) > 0) {
            $EmailError = 'User already exists';
        } else {
            $insert = "INSERT INTO userr_form (Name, Email, Password, user_type) VALUES ('$Name', '$Email', '$Password', '$user_type')";
            mysqli_query($con, $insert);
            header('location: loginn.php');
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="regggg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    function validateName() {
        var name = document.getElementById('name').value;
        var nameError = document.getElementById('nameError');
        var regex = /^[a-zA-Z' -]+$/;
        if(name===''){
            nameError.textContent = '';
        } else if (!regex.test(name) || /^\s/.test(name)) {
            nameError.textContent = 'Name can only contain letters, spaces, apostrophes, and hyphens, and cannot start with a space';
        } else {
            nameError.textContent = '';
        }
    }

    function validateEmail() {
        var email = document.getElementById('email').value;
        var emailError = document.getElementById('emailError');
        var regex = /^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9-]+\.[a-zA-Z]{2,3}$/;
        
        if (email === '') {
            emailError.textContent = '';
        } else if (!regex.test(email)) {
            emailError.textContent = 'Email must start with a letter, contain only letters, numbers, dots, underscores, and hyphens, and follow the format: name@domain.com';
        } else {
            emailError.textContent = '';
        }
    }

    function validatePassword() {
    var password = document.getElementById('password').value;
    var passwordError = document.getElementById('passwordError');
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

    if (password === '') {
        passwordError.textContent = '';
    } else if (!regex.test(password)) {
        passwordError.textContent = 'Password must be at least 8 characters long, and include at least one uppercase letter, one lowercase letter, one number, and one special character';
    } else {
        passwordError.textContent = '';
    }
}


    function validateCpassword() {
        var password = document.getElementById('password').value;
        var cpassword = document.getElementById('cpassword').value;
        var cpasswordError = document.getElementById('cpasswordError');
        if (cpassword === '') {
            cpasswordError.textContent = '';
        } else if (password !== cpassword) {
            cpasswordError.textContent = 'Passwords did not match';
        } else {
            cpasswordError.textContent = '';
        }
    }

    function togglePasswordVisibility(id) { 
    var input = document.getElementById(id); 
    var icon = document.getElementById(id + '-icon'); 
    if (input.type === "password") { 
        input.type = "text"; 
        icon.classList.remove('fa-eye'); 
        icon.classList.add('fa-eye-slash'); 
        } else { 
            input.type = "password"; 
            icon.classList.remove('fa-eye-slash'); 
            icon.classList.add('fa-eye'); 
            }
            }
</script>
</head>
<body>
<div><a href="dashboardd.php"><img src="final.png"></a></div>
<div class="form-container">
    <form action="" method="post">
        <h1>Register Now</h1>

        <input type="text" id="name" name="name" required placeholder="Enter your name" oninput="validateName()">
        <span class="error-msg" id="nameError"><?php echo $NameError; ?></span>

        <input type="email" id="email" name="email" required placeholder="Enter your email" oninput="validateEmail()">
        <span class="error-msg" id="emailError"><?php echo $EmailError; ?></span>
<div class="input-password">
        <input type="password" id="password" name="password" required placeholder="Enter your password" oninput="validatePassword()">
        <i id="password-icon" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password')"></i>
        </div>
        <span class="error-msg" id="passwordError"><?php echo $PasswordError; ?></span>
     
        <div class="input-password">
        <input type="password" id="cpassword" name="cpassword" required placeholder="Confirm your password" oninput="validateCpassword()">
        <i id="cpassword-icon" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('cpassword')"></i>
        </div>
        <span class="error-msg" id="cpasswordError"><?php echo $CpasswordError; ?></span>

        <input type="submit" name="submit" value="Register now" class="form-btn">
        <p>Already have an account?<a href="loginn.php"> Login Now</a></p>
    </form>
</div>
</body>
</html>
