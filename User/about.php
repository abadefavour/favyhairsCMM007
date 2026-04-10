<?php
session_start();
include "../db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About - FavyHairs</title>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>

<div class="about-page">

    <h1>About FavyHairs Equipment Rental</h1>

    <p>
        FavyHairs is a professional platform designed to allow hairstylists and beauty
        enthusiasts to rent high-quality hair equipment. Our goal is to make professional
        tools easily accessible without the need for expensive purchases. Users can
        browse equipment, rent items, and return them conveniently.
    </p>

    <h2>Equipment Categories</h2>

<div class="card-grid"> 

    <div class="category">
        <h3>1. Hair Cutting Equipment</h3>
        <ul>
            <li>Hair Cutting Scissors</li>
            <li>Thinning Scissors</li>
            <li>Electric Hair Clippers</li>
            <li>Hair Trimmers</li>
            <li>Razor Comb</li>
        </ul>
    </div>
    
    <div class="category">
        <h3>2. Hair Styling Equipment</h3>
        <ul>
            <li>Hair Dryer</li>
            <li>Hair Straightener</li>
            <li>Curling Iron</li>
            <li>Curling Wand</li>
            <li>Hot Rollers</li>
        </ul>
    </div>

    <div class="category">
        <h3>3. Combs and Brushes</h3>
        <ul>
            <li>Wide Tooth Comb</li>
            <li>Tail Comb</li>
            <li>Paddle Brush</li>
            <li>Round Brush</li>
            <li>Detangling Brush</li>
        </ul>
    </div>

    <div class="category">
        <h3>4. Hair Treatment Equipment</h3>
        <ul>
            <li>Hair Steamer</li>
            <li>Hair Spa Machine</li>
            <li>Infrared Hair Processor</li>
            <li>Scalp Massager</li>
        </ul>
    </div>

    <div class="category">
        <h3>5. Hair Coloring Equipment</h3>
        <ul>
            <li>Hair Color Brushes</li>
            <li>Mixing Bowls</li>
            <li>Foil Sheets</li>
            <li>Tint Bottles</li>
            <li>Highlighting Caps</li>
        </ul>
    </div>

    <div class="category">
        <h3>6. Hair Washing Equipment</h3>
        <ul>
            <li>Shampoo Basin</li>
            <li>Spray Bottle</li>
            <li>Hair Towels</li>
            <li>Shampoo Brushes</li>
        </ul>
    </div>

    <div class="category">
        <h3>7. Hair Extension Tools</h3>
        <ul>
            <li>Braiding Needle</li>
            <li>Crochet Needle</li>
            <li>Hair Extension Pliers</li>
            <li>Loop Tool</li>
        </ul>
    </div>

    <div class="category">
        <h3>8. Hair Accessories</h3>
        <ul>
            <li>Hair Clips</li>
            <li>Bobby Pins</li>
            <li>Hair Bands</li>
            <li>Hair Nets</li>
        </ul>
    </div>

    <div class="category">
        <h3>9. Professional Salon Equipment</h3>
        <ul>
            <li>Salon Chair</li>
            <li>Styling Station</li>
            <li>Trolley Cart</li>
            <li>Sterilizer Cabinet</li>
        </ul>
    </div>

    <div>
        <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
    </div>

</div>

</body>
</html>