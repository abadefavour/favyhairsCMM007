<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="logout-container">
    <h2>Logout</h2>
    <p>Are you sure you want to logout?</p>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>