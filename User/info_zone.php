<?php
session_start();
include "../db_connect.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Information Zone | FavyHairs</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav>
<a href="about.php">About</a>
<a href="contact.php">Contact Us</a>
<a href="user_rental.php">Rent Equipment</a>
<a href="user_return.php">Return Equipment</a>
<a href="view_equipment.php">View Equipment</a>
<a href="info_zone.php">Information Zone</a>
<a href="profile.php">Profile</a>
</nav>

<div class="container">

<h2>Information Zone</h2>
<p class="intro">Here you’ll find useful tips and guidance for renting and using our salon equipment safely and efficiently.</p>

<div class="info-grid">

<div class="info-card">
<h3>How to Rent Equipment</h3>
<p>Select the equipment you want to rent, check availability, and click the Rent button. Ensure you read the instructions before use.</p>
</div>

<div class="info-card">
<h3>Equipment Care Tips</h3>
<p>Always clean and store equipment properly after use. Avoid water damage, and report any faults immediately.</p>
</div>

<div class="info-card">
<h3>Return Guidelines</h3>
<p>Return equipment on time. Make sure it is in good condition. Late returns may incur extra fees.</p>
</div>

<div class="info-card">
<h3>Contact Support</h3>
<p>If you face any issues, reach out to us via the Contact Us page. Our team will respond within 24 hours.</p>
</div>

</div>

</div>

<a href="dashboard.php"  class="dashboard-pill">Back to Dashboard</a>
</body>

</html>