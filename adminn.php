<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
    header('location:login.php');
    exit;
}

// Fetch blood stock
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
    <title>BBMS-Admin</title>
    <link rel="stylesheet" href="add_min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script> 
    function toggleForm() { 
        var form = document.getElementById("stockForm"); 
        if (form.style.display === "none" || form.style.display === "") { 
            form.style.display = "block"; 
            newBloodForm.style.display = "none";
        } else { 
            form.style.display = "none"; 
        }
    } 
   
    function hideForms(event) { 
        var stockForm = document.getElementById("stockForm"); 
        var newBloodForm = document.getElementById("newBloodForm"); 
        var updateButton = document.querySelector('.update button:nth-child(1)'); 
        var addButton = document.querySelector('.update button:nth-child(2)'); 
        if (!stockForm.contains(event.target) && event.target !== updateButton) { 
            stockForm.style.display = "none"; 
        } 
            if (!newBloodForm.contains(event.target) && event.target !== addButton) {
                 newBloodForm.style.display = "none"; 
                } 
        } 
        
        document.addEventListener("DOMContentLoaded", function() { 
            document.getElementById("stockForm").style.display = "none"; 
            document.addEventListener("click", hideForms); 

    });
             
    </script>
</head>
<body>  
    <header>
    <nav>   
        <ul>
            <li><a href="ad_users.php">Users</a></li>
            <li><a href="ad_req.php">Request History</a></li>
            <li><a href="ad_don.php">Donation History</a></li>
        </ul>
        <div class="img_a"><a href="adminn.php"><img src="final.png" alt=""></a></div>
        <h2>Hi<span>&nbsp;<?php echo $_SESSION['admin_name']?></span></h2>
        <a href="logout.php"><h4>LOGOUT</h4></a>
    </nav>
    </header>
    
    <div class="update">
        <button onclick="toggleForm()">Add/Update Stock</button>
        <form id="stockForm" action="update_stock.php" method="post" style="display:none;">
            <label for="blood_type">Blood Type:</label>
            <select name="blood_type" id="blood_type" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="0" required>
            <input type="submit" value="Add/Update">
        </form>
        
    </div>
        <div class="container">
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
