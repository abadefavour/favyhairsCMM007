<?php
session_start();
include "../db_connect.php";


if($_SESSION['role'] != "admin"){
    header("Location: ..
    /login.php");
    exit();
}

$message = "";

if(isset($_POST['add_equipment'])){

    $name = $_POST['equipment_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $condition = $_POST['condition'];
    $description = $_POST['description'];

    
    $sql = "INSERT INTO equipment_table 
    (name, price_per_day, category, quantity, equipment_condition, description, status) 
    VALUES 
    ('$name', '$price', '$category', '$quantity', '$condition', '$description', 'available')";

    if($conn->query($sql)){
        $message = "Equipment added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/style_3.css">
</head>

<body>



<div class="container">

<h3>Add Equipment</h3>

<p><?php echo $message; ?></p>

<form method="POST">

<input type="text" name="equipment_name" placeholder="Name" required>

<input type="number" step="0.01" name="price" placeholder="Price per day" required>

<input type="text" name="category" placeholder="Category" required>

<input type="number" name="quantity" placeholder="Quantity" required>

<select name="condition" required>
    <option value="">Select Condition</option>
    <option value="new">New</option>
    <option value="good">Good</option>
    <option value="fair">Fair</option>
    <option value="poor">Poor</option>
</select>

<textarea name="description" placeholder="Description" rows="4" required></textarea>

<button type="submit" name="add_equipment">Add Equipment</button>

</form>

</div>

</body>
</html>