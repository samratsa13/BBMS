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

    // Check current stock
    $stock_query = "SELECT quantity FROM blood_stock WHERE blood_type = '$blood_group'";
    $stock_result = mysqli_query($con, $stock_query);
    $stock_row = mysqli_fetch_assoc($stock_result);
    $current_stock = intval($stock_row['quantity']);

    if ($action == 'accept') {
        if ($current_stock >= $blood_count) {
            // Update stock and request status
            $query = "UPDATE blood_stock SET quantity = quantity - $blood_count WHERE blood_type = '$blood_group'";
            $update_status = "UPDATE req_history SET status = 'accepted' WHERE id = $id";

            if (mysqli_query($con, $query) && mysqli_query($con, $update_status)) {
                // Redirect back with success message
                header("location:ad_req.php?message=success&id=$id");
                exit;
            } else {
                echo "Error updating blood stock or request status: " . mysqli_error($con);
            }
        } else {
            // Redirect back with error message
            header("location:ad_req.php?message=nostock&id=$id");
            exit;
        }
    } else if ($action == 'reject') {
        // Update request status to rejected
        $update_status = "UPDATE req_history SET status = 'rejected' WHERE id = $id";

        if (mysqli_query($con, $update_status)) {
            // Redirect back with success message
            header("location:ad_req.php?message=rejected&id=$id");
            exit;
        } else {
            echo "Error updating request status: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid input.";
}
?>
