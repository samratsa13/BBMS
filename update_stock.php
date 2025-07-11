<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['blood_type']) && isset($_POST['quantity'])) {
    $blood_type = mysqli_real_escape_string($con, $_POST['blood_type']);
    $quantity = intval($_POST['quantity']);

    // Check if the blood type already exists in the stock
    $check_query = "SELECT * FROM blood_stock WHERE blood_type = '$blood_type'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Blood type exists, update the quantity
        $update_query = "UPDATE blood_stock SET quantity = quantity + $quantity WHERE blood_type = '$blood_type'";
        if (mysqli_query($con, $update_query)) {
            $_SESSION['message'] = "Stock updated successfully!";
        } else {
            $_SESSION['message'] = "Error updating stock: " . mysqli_error($con);
        }
    } else {
        // Blood type does not exist, insert new record
        $insert_query = "INSERT INTO blood_stock (blood_type, quantity) VALUES ('$blood_type', '$quantity')";
        if (mysqli_query($con, $insert_query)) {
            $_SESSION['message'] = "Stock added successfully!";
        } else {
            $_SESSION['message'] = "Error adding stock: " . mysqli_error($con);
        }
    }

    // Redirect back to the page with the form
    header('location:adminn.php');
    exit;
} else {
    $_SESSION['message'] = "Invalid input.";
    header('location:adminn.php');
    exit;
}
?>
