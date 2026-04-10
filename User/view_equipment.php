<?php
session_start();
include "../db_connect.php";

$conn = new mysqli("localhost","root","","favyhairs");

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Equipment | FavyHairs</title>

<link rel="stylesheet" href="../css/style_4.css">
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

<h2>Available Hair Equipment</h2>

<p class="intro">
Browse our professional salon equipment available for rent.
</p>

<table>

<tr>
<th>Equipment</th>
<th>Price Per Day</th>
<th>Status</th>
</tr>

<?php

$result = $conn->query("SELECT * FROM equipment_table");

if($result && $result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        // ✅ USE STOCK INSTEAD OF STATUS
        if(isset($row['stock']) && $row['stock'] > 0){
            $status = "available";
            $status_class = "available";
        } else {
            $status = "unavailable";
            $status_class = "unavailable";
        }

        echo "<tr>";

        echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";        
        echo "<td>£" . htmlspecialchars($row['price_per_day'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td class='" . $status_class . "'>" . $status . "</td>";

        echo "</tr>";
    }

}else{
    echo "<tr><td colspan='3'>No equipment found</td></tr>";
}

$conn->close();

?>

</table>

</div>

</body>
</html>