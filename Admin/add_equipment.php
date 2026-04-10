<?php
session_start();
include "../db_connect.php";

// ✅ HANDLE LOGOUT
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: /FAVYHAIRS/User/login.php");
    exit();
}

// ✅ Protect page (MUST match all pages)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
    header("Location: /FAVYHAIRS/User/login.php");
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
<title>Add Equipment</title>
<link rel="stylesheet" href="../css/style_3.css">
</head>

<body>

<!-- ✅ NAVBAR -->
<div style="background:#2c3e50; padding:10px; display:flex; justify-content:space-between; align-items:center;">
    
    <div>
        <!-- ✅ FIXED DASHBOARD LINK -->
        <a href="/FAVYHAIRS/Admin/admin_dashboard.php" style="color:white; text-decoration:none; font-weight:bold;">
            Dashboard
        </a>
    </div>

    <div>
        <form method="POST" style="display:inline;">
            <button type="submit" name="logout" 
                style="background:#e74c3c; color:white; border:none; padding:6px 12px; cursor:pointer;">
                Logout
            </button>
        </form>
    </div>

</div>

<div class="container">

<h3>Add Equipment</h3>

<?php if(!empty($message)) echo "<p>$message</p>"; ?>

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