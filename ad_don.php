<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']);
    $query = "SELECT * FROM don_history WHERE name LIKE '%$search%'";
} else {
    $query = "SELECT * FROM don_history";
}
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Requests</title>
    <link rel="stylesheet" href="admin_don.css">
    <script src="table2excel.js"></script>

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
            <a href="logout.php"><h4>LOGOUT</h4></a>
        </nav>
    </header>
    <div class="container">
        <h1>Blood Donation Requests</h1>
        <div class="search">
            <form method="post" action="">
                <input type="text" name="search" id="srch" placeholder="Search by name" value="<?php echo $search; ?>">
                <input type="submit" value="Search" id="btn">
            </form>
        </div>
        <div class="table"><center>
        <table id="tbll"border="1" cellspacing="30" cellpadding="10">
            <tr>
                <th>Donation ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Blood Count</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Disease</th>
                <th>Actions</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['blood_group'] . "</td>";
                    echo "<td>" . $row['bloodcount'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['contact'] . "</td>";
                    echo "<td>" . $row['disease'] . "</td>";
                    echo "<td>";
                    if ($row['status'] == 'pending') {
                        echo "<form method='post' action='update_stockdon.php' style='display:inline;'>";
                        echo "<input type='hidden' name='action' value='accept'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='blood_group' value='" . $row['blood_group'] . "'>";
                        echo "<input type='hidden' name='blood_count' value='" . $row['bloodcount'] . "'>";
                        echo "<button class='accept'>Accept</button>";
                        echo "</form>";
                        echo "<form method='post' action='update_stockdon.php' style='display:inline;'>";
                        echo "<input type='hidden' name='action' value='reject'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='blood_group' value='" . $row['blood_group'] . "'>";
                        echo "<input type='hidden' name='blood_count' value='" . $row['bloodcount'] . "'>";
                        echo "<button class='reject'>Reject</button>";
                        echo "</form>";
                    } else {
                        $status_class = $row['status'] == 'accepted' ? 'status-accepted' : 'status-rejected';
                        echo "<span class='$status_class'>" . ucfirst($row['status']) . "</span>"; // Display the status (Accepted/Rejected)
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No donations found</td></tr>";
            }
            ?>
        </table>
        </center>
    </div>
    <br>
    <button id="downloadexcel">Export to Excel</button>
    </div>
    <script>
    document.getElementById('downloadexcel').addEventListener('click', function() {
        var table2excel = new Table2Excel();
        table2excel.export(document.querySelectorAll("#tbll"));
    });
</script>
</body>
</html>
