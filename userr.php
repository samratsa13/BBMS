<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
    header('location:login.php');
}

$blood_stock_query = "SELECT * FROM blood_stock";
$blood_stock_result = mysqli_query($con, $blood_stock_query);

$blood_stock = [];
if (mysqli_num_rows($blood_stock_result) > 0) {
    while ($row = mysqli_fetch_assoc($blood_stock_result)) {
        $blood_stock[$row['blood_type']] = $row['quantity'];
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBMS-User</title>
    <link rel="stylesheet" href="uuser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
   
            <a href="dashboardd.php"><img src="final.png" alt=""></a>
            <h2>Hi<span>&nbsp;
                    <?php echo $_SESSION['user_name']?>
                </span></h2>
            
           
            <a href="logout.php"><h4>LOGOUT</h4></a>
           
        </div>
</nav>
</header>
<div class="container">
        <div class="content">
        <div class="bloods">
            <div class="Apos">
                <h1>A+</h1>
                <h2><?php echo $blood_stock['A+'] ?? 0; ?></h2>
                
            </div>
            <div class="Aneg">
                <h1>A-</h1>
                <h2><?php echo $blood_stock['A-'] ?? 0; ?></h2>
            </div>
            <div class="Bpos">
                <h1>B+</h1>
                <h2><?php echo $blood_stock['B+'] ?? 0; ?></h2>
            </div>
            <div class="Bneg">
                <h1>B-</h1>
                <h2><?php echo $blood_stock['B-'] ?? 0; ?></h2>
            </div>
            <div class="ABpos">
                <h1>AB+</h1>
                <h2><?php echo $blood_stock['AB+'] ?? 0; ?></h2>
            </div>
            <div class="ABneg">
                <h1>AB-</h1>
                <h2><?php echo $blood_stock['AB-'] ?? 0; ?></h2>
            </div>
            <div class="Opos">
                <h1>O+</h1>
                <h2><?php echo $blood_stock['O+'] ?? 0; ?></h2>
            </div>
            <div class="Oneg">
                <h1>O-</h1>
                <h2><?php echo $blood_stock['O-'] ?? 0; ?></h2>
            </div>



        </div>
    </div>
</body>

</html>