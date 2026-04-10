<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['first_name'] ?? "User";
$user_email = $_SESSION['email'] ?? "user@example.com";
$user_phone = $_SESSION['phone'] ?? "+44 7000 000000";
$user_membership = $_SESSION['membership'] ?? "Standard";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile | FavyHairs</title>
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

<h2>Your Profile</h2>
<p class="intro">Manage your account information and membership details here.</p>

<div class="profile-card">

<div class="profile-row">
<span class="label">Name:</span>
<span class="value"><?php echo htmlspecialchars($user_name); ?></span>
</div>

<div class="profile-row">
<span class="label">Email:</span>
<span class="value"><?php echo htmlspecialchars($user_email); ?></span>
</div>

<div class="profile-row">
<span class="label">Phone:</span>
<span class="value"><?php echo htmlspecialchars($user_phone); ?></span>
</div>

<div class="profile-row">
<span class="label">Membership:</span>
<span class="value"><?php echo htmlspecialchars($user_membership); ?></span>
</div>

</div>

</div>

</body>
</html>