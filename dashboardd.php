<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header>
        <nav>
            <a href="dashboardd.php"><label class="logo"><img src="final.png"></label></a>
            <ul>
                <li><a href="#First">Home</a></li>
                <li><a href="#About">Why BBMS</a></li>
                <li><a href="#Contact">Contact</a></li>
                <li><a href="registerr.php">Sign Up</a></li>
                <li><a href="loginn.php">Sign In</a></li>

            </ul>
        </nav>
    </header>
    <section id="First">
        <div class="img">
            <br>
            <br><br><br>
            <h1>Donate <span>Blood</span></h1>
            <h2> Save Life </h2>

            <img src="desk.png" alt="">
            <div class="link">
                <a href="registerr.php"><input type="submit" name="submit" value="Its my first visit" class="btn1"></a>
                <br>
            </div>
            <div class="link2">
                <a href="loginn.php">I'm regular here</a>
            </div>

        </div>
    </section>

    <!--About us-->

    <section id="About">

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <!--<div class="box">-->
        <div class="intro">
            <h1>Why BBMS?</h1>
            <br>
            <p>Our innovative online blood bank management system offers a streamlined and
                efficient way to connect blood donors with those in need. We provide real-time
                updates on blood stock availability, ensuring that patients can access the life-saving
                resource they require promptly.</p>
        </div>
        <div class="key1">
            <h1>Transparent and Efficient</h1>
            <br>
            <p>Our system offers a transparent platform for both donors and recipients,
                simplifying the process of blood donation and distribution</p>
        </div>
        <div class="key2">
            <h1>Convenient and Accessible</h1>
            <br>
            <p>Our user-friendly platform can be accessed easily ,
                making it convenient for both donors and recipients to participate.</p>
        </div>
        <div class="key3">
            <h1>Regular Blood Stock Updates</h1>
            <br>
            <p>Stay informed about the current blood stock levels,
                enabling quick and easy access for patients</p>
        </div>
        <br>
        <br>
        <br>
    </section>
    <!--Section 3 starts-->
    <section id="third">
        <div class="head">
            <br>

            <br>
            <br>
            <h1>Blood Type Compabilities</h1>
            <br>
            <br><br>
        </div>
        <table>
            <tr>
                <th>
                    Type
                </th>
                <th>
                    Give Blood to
                </th>
                <th>
                    Can Recieve from
                </th>
            </tr>
            <tr>
                <td>A+</td>
                <td>A+&nbsp;AB+</td>
                <td>A+&nbsp;A-&nbsp;O+&nbsp;O-</td>
            </tr>
            <tr>
                <td>O+</td>
                <td>O+&nbsp;A+&nbsp;B+&nbsp;AB+</td>
                <td>O+&nbsp;O-</td>
            </tr>
            <tr>
                <td>B+</td>
                <td>B+&nbsp;AB+</td>
                <td>B+&nbsp;B-&nbsp;O+&nbsp;O-</td>
            </tr>
            <tr>
                <td>AB+</td>
                <td>AB+</td>
                <td>Everyone</td>
            </tr>
            <tr>
                <td>A-</td>
                <td>A+&nbsp;A-&nbsp;AB+&nbsp;AB-</td>
                <td>A-&nbsp;O-</td>
            </tr>
            <tr>
                <td>O-</td>
                <td>Everyone</td>
                <td>O-</td>
            </tr>
            <tr>
                <td>B-</td>
                <td>B+&nbsp;B-&nbsp;AB+&nbsp;AB-</td>
                <td>B-&nbsp;O-</td>
            </tr>
            <tr>
                <td>AB-</td>
                <td>AB+&nbsp;AB-</td>
                <td>AB-&nbsp;A-&nbsp;B-&nbsp;O-</td>
            </tr>
        </table>
        <br>
        <br>
    </section>
    <!--Contacct-->

    <section id="Contact">
        <div class="con">
            <h1>CONTACT US</h1>
        </div>
        <div class="log">
            <img src="final.png">
            <h1>BBMS</h1>
        </div>
        <div class="chitwan">
            <h2>Chitwan</h2>
            <br>
            <ul>
                <li>Province: Bagmati</li>
                <li>District: Chitwan</li>
                <li>Address: Bharatpur Metropolitan-3, Narayanghat</li>
                <li>Phone: 056-520133</li>
                <li>Fax: 056-526265</li>
                <li>Email: nrcsnrg@wlink.com.np,
                    nrcsng@nc.com.np</li>
            </ul>
        </div>
        <div class="ktm">
            <h2>Kathmandu</h2>
            <br>
            <ul>
                <li>Province: Bagmati</li>
                <li>District: Kathmandu</li>
                <li>Address: Kathmandu Metropolitan-31, Baagbazar</li>
                <li>Phone: 01-4229410, 01-4219131</li>
                <li>Fax: 01-4229199</li>
                <li>Email: info@ktmredcross.org.np</li>
            </ul>
        </div>

        <div class="web">
            <a href="https://nrcs.org/"><i class="fa-brands fa-chrome"></i></a>
            <h3>Nepal Red Cross Society<h3>
        </div>

    </section>
</body>

</html>