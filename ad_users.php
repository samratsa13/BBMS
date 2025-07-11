<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['admin_name'])){
    header('location:login.php');
}

$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']);
}

$query = "SELECT * FROM userr_form WHERE name LIKE '%$search%' AND user_type='user'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="add_userss.css">
</head>
<body>
    <header>
    <nav>   
         <ul>
                <li><a href="ad_users.php">Users</a></li>
                
                <li><a href="ad_req.php">Request History</a></li>
                <li><a href="ad_don.php">Donation Requests</a></li>
            </ul>
   
            <a href="adminn.php"><img src="final.png" alt=""></a>
            <h2>Hi<span>&nbsp;<?php echo $_SESSION['admin_name']?></span></h2>
            
            <a href="logout.php"><a href="logout.php"><h4>LOGOUT</h4></a>
        </nav>
    </header>
    <div class="container">
        <h1>Users List</h1>
        <!-- Search Form -->
        <div class="search">
            <form method="post" action="">
                <input type="text" name="search" id="srch" placeholder="Search by name" value="<?php echo $search; ?>">
                <input type="submit" value="Search" id="btn">
            </form>
        </div>
        <div class="table"><center>
            <table border="1" cellspacing="40" cellpadding="10">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" .$row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>
                               
                                <form method='post' action='del_user.php' style='display:inline;'>
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
