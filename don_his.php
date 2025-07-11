<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
    header('location:login.php');
}
?>
<?php
$user_id = $_SESSION['user_id'];
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']);
}

// Fetch data from the req_history table based on search
$query = "SELECT * FROM don_history WHERE user_id = '$user_id' AND name LIKE '%$search%'"; 
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Donations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="do_on.css">
</head>
<body>
    <header>
    <nav>   
         <ul>
                <li><a href="donate.php">Donate</a></li>
                <li><a href="request.php">Request</a></li>
                <li><a href="req_his.php">Request History</a></li>
                <li><a href="registerr.php">Donation History</a></li>
                

            </ul>
   
            <a href="userr.php"><img src="final.png" alt=""></a>
            <h2>Hi<span>&nbsp;
                    <?php echo $_SESSION['user_name']?>
                </span></h2>
            
           
            <a href="logout.php"><h4>LOGOUT</h4></a>
           
        </div>
</nav>
</header>
<div class="container">
    <h1>Blood Donations List</h1>
    <!-- Search Form -->
    <div class="search">
    <form method="post" action="">
        <input type="text" name="search" id="srch" placeholder="Search by name" value="<?php echo $search; ?>">
        <input type="submit" value="Search" id="btn">
    </form>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="table"><center>
            <table border="1" cellspacing="40" cellpadding="10">
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Blood Group</th>
                    <th>Blood Count</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Disease</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['blood_group'] . "</td>";
                        echo "<td>" . $row['bloodcount'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['disease'] . "</td>";
                        $status_class = $row['status'] == 'accepted' ? 'status-accepted' : ($row['status'] == 'rejected' ? 'status-rejected' : ($row['status'] == 'pending' ? 'status-pending' : ''));
                        echo "<td class='$status_class'>" . ucfirst($row['status']) . "</td>";
                        echo "<td>
                                <form method='post' action='editdon.php' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <input type='submit' value='Edit'>
                                </form>
                                <form method='post' action='delete.php' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <input type='submit' value='Delete'>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }
                ?>
            </table>
        </center>
            </div>
    </div>
</body>
</html>
