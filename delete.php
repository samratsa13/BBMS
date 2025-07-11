<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM req_history WHERE id = $id";
    
    if (mysqli_query($con, $query)) {
        // Redirect back to request history page after deletion
        header('location:req_his.php');
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    echo "Invalid input.";
}


//yo chai donation data delete
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM don_history WHERE id='$id'";

    if (mysqli_query($con, $query)) {
        header('location:don_his.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}
?>
