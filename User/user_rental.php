<?php
session_start();
include "../db_connect.php";

$conn = new mysqli("localhost", "root", "", "favyhairs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['first_name'] ?? "User";
$message = "";

if (isset($_POST['rent']) && isset($_POST['equipment_id'])) {

    $equipment_id = intval($_POST['equipment_id']);
    $user_id = $_SESSION['user_id'];
    $rent_date = date("Y-m-d");

    try {
        $conn->begin_transaction();

        /* ================================
           LIMIT 1: MAX ACTIVE RENTALS
        ================================= */
        $max_rentals = 3;

        $checkRentals = $conn->prepare("
            SELECT COUNT(*) as total 
            FROM rental_table 
            WHERE user_id=? AND status='rented'
        ");
        $checkRentals->bind_param("i", $user_id);
        $checkRentals->execute();
        $resultCheck = $checkRentals->get_result();
        $data = $resultCheck->fetch_assoc();

        if ($data['total'] >= $max_rentals) {
            throw new Exception("You can only rent up to $max_rentals items at a time.");
        }

        /* ================================
           LOCK EQUIPMENT ROW
        ================================= */
        $stmt = $conn->prepare("
            SELECT stock 
            FROM equipment_table 
            WHERE id=? 
            FOR UPDATE
        ");
        $stmt->bind_param("i", $equipment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $equipment = $result->fetch_assoc();

        if (!$equipment) {
            throw new Exception("Equipment not found.");
        }

        if ($equipment['stock'] <= 0) {
            throw new Exception("Item is out of stock.");
        }

        /* ================================
           PREVENT DUPLICATE RENTAL
        ================================= */
        $checkDuplicate = $conn->prepare("
            SELECT id 
            FROM rental_table 
            WHERE user_id=? 
            AND equipment_id=? 
            AND status='rented'
        ");
        $checkDuplicate->bind_param("ii", $user_id, $equipment_id);
        $checkDuplicate->execute();
        $dupResult = $checkDuplicate->get_result();

        if ($dupResult->num_rows > 0) {
            throw new Exception("You already rented this item.");
        }

        /* ================================
           UPDATE STOCK
        ================================= */
        $updateStock = $conn->prepare("
            UPDATE equipment_table 
            SET stock = stock - 1 
            WHERE id=?
        ");
        $updateStock->bind_param("i", $equipment_id);
        $updateStock->execute();

        /* ================================
           INSERT RENTAL
        ================================= */
        $insertRental = $conn->prepare("
            INSERT INTO rental_table 
            (equipment_id, user_id, rent_date, status)
            VALUES (?, ?, ?, 'rented')
        ");
        $insertRental->bind_param("iis", $equipment_id, $user_id, $rent_date);
        $insertRental->execute();

        $conn->commit();
        $message = "Equipment rented successfully!";

    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FavyHairs - Rent Equipment</title>

<link rel="stylesheet" href="../css/style_4.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>

<nav>
<a href="about.php">About</a>
<a href="contact.php">Contact Us</a>
<a href="user_rental.php">Rent an Item</a>
<a href="user_return.php">Return an Item</a>
<a href="view_equipment.php">View Equipment</a>
<a href="info_zone.php">Information Zone</a>
<a href="profile.php">Profile</a>

<form method="POST" style="display:inline;">
    <button type="submit" name="logout" class="logout-btn">Logout</button>
</form>
</nav>

<div class="container">

<h2 class="welcome">Rent Hair Equipment</h2>

<p>Welcome, <?php echo htmlspecialchars($user_name); ?></p>

<div class="sales-message">
    Choose from our premium salon equipment and start renting today!
</div>

<?php
if (!empty($message)) {
    echo "<p style='color:green;font-weight:bold;'>" . htmlspecialchars($message) . "</p>";
}
?>

<table>

<tr>
    <th>Equipment</th>
    <th>Price Per Day</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM equipment_table WHERE stock > 0");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

<tr>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td>£<?php echo htmlspecialchars($row['price_per_day']); ?></td>
    <td><?php echo htmlspecialchars($row['stock']); ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="equipment_id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="rent">Rent</button>
        </form>
    </td>
</tr>

<?php
    }
} else {
    echo "<tr><td colspan='4'>No equipment available</td></tr>";
}
?>

</table>

 <div>
        <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
    </div>

</div>

</body>
</html>