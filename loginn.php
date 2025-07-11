<?php
@include 'config.php';
session_start();

$emailError = '';
    $passwordError = ''; 

if(isset($_POST['submit'])){
    $Email= mysqli_real_escape_string($con,$_POST['email']);
    $Password= md5($_POST['password']);
    
    
    // Check if email exists 
    $selectem = "SELECT * FROM userr_form WHERE Email='$Email'";
    $resultem = mysqli_query($con, $selectem);
    
    if (mysqli_num_rows($resultem) == 0) {
         $emailError = 'Incorrect Email'; 
        } 
        else { // Check if password is correct 
        $selectpss= "SELECT * FROM userr_form WHERE Email='$Email' AND Password='$Password'";
        $resultpss = mysqli_query($con, $selectpss);
        
        if (mysqli_num_rows($resultpss) == 0) {
            $passwordError = 'Incorrect Password'; 
        } else{
 
        $row = mysqli_fetch_array($resultpss);
        $_SESSION['user_id'] = $row['id']; 
        $_SESSION['user_type'] = $row['user_type'];

        if($row['user_type']=='admin'){

            $_SESSION['admin_name']=$row['name'];
            header('location:adminn.php');

        }elseif($row['user_type']=='user'){

            $_SESSION['user_name']=$row['name'];
            header('location:userr.php');
        }
        }
}
};

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="loginnn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script>
            function togglePasswordVisibility(id) {
                var input = document.querySelector("input[name=" + id + "]"); 
                var icon = document.getElementById(id + '-icon'); 
                if (input.type === "password") { input.type = "text"; 
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
            <h1>Login</h1>
            <?php
    if(isset($error)){
        foreach($error as $error){
            echo'<span class="error-msg">'.$error.'</span>';
        };
    };
    ?>
            <input type="email" name="email" required placeholder="Enter you email">
            <span class="error-msg"><?php echo $emailError; ?></span>
            <div class="input-password">
            <input type="password" name="password" required placeholder="Enter your password">
            <i id="password-icon" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password')"></i>
            </div>
            <span class="error-msg"><?php echo $passwordError; ?></span>
            <input type="submit" name="submit" value="Login" class="form-btn">
            <p>Didn't have an account?<a href="registerr.php"> Register Now</a></p>
        </form>
    </div>
</body>

</html>