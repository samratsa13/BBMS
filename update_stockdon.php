<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['action']) && isset($_POST['id']) && isset($_POST['blood_group']) && isset($_POST['blood_count'])) {
    $action = $_POST['action'];
    $id = intval($_POST['id']);
    $blood_group = mysqli_real_escape_string($con, $_POST['blood_group']);
    $blood_count = intval($_POST['blood_count']);

    if ($action == 'accept') {
        // Increase blood count in stock for donations
        $query = "UPDATE blood_stock SET quantity = quantity + $blood_count WHERE blood_type = '$blood_group'";
        $update_status = "UPDATE don_history SET status = 'accepted' WHERE id = $id";
        
        if (mysqli_query($con, $query) && mysqli_query($con, $update_status)) {
            // Redirect back to donation requests history
            header('location:ad_don.php');
            exit;
        } else {
            echo "Error updating blood stock or request status: " . mysqli_error($con);
        }
    } else if ($action == 'reject') {
        // Update status to rejected
        $update_status = "UPDATE don_history SET status = 'rejected' WHERE id = $id";
        
        if (mysqli_query($con, $update_status)) {
            // Redirect back to donation requests history
            header('location:ad_don.php');
            exit;
        } else {
            echo "Error updating request status: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid input.";
}
?>
