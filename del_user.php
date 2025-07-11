<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    
    $query = "DELETE FROM userr_form WHERE id='$id'";
    if (mysqli_query($con, $query)) {
        header('location:ad_users.php'); // Redirect to the admin portal after deletion
        exit; // Ensure no further code is executed
    } else {
        echo "Error deleting user: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>
