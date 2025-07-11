<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['new_blood_type']) && isset($_POST['new_quantity'])) {
    $new_blood_type = mysqli_real_escape_string($con, $_POST['new_blood_type']);
    $new_quantity = intval($_POST['new_quantity']);
    
    $query = "INSERT INTO blood_stock (blood_type, quantity) VALUES ('$new_blood_type', '$new_quantity') 
              ON DUPLICATE KEY UPDATE quantity='$new_quantity'";
              
    if (mysqli_query($con, $query)) {
        header('location:adminn.php'); // Redirect back to the admin dashboard after adding new blood type
        exit;
    } else {
        echo "Error adding new blood type: " . mysqli_error($con);
    }
} else {
    echo "Invalid input.";
}
?>
