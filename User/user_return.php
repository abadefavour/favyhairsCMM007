<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "favyhairs");

if ($conn->connect_error) {
    die("Database connection failed.");
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['first_name'] ?? "User";
$message = "";

if (isset($_POST['return']) && isset($_POST['rental_id'])) {

    $rental_id = intval($_POST['rental_id']);

    $conn->begin_transaction();

    try {

        $stmt = $conn->prepare("
            SELECT equipment_id 
            FROM rental_table 
            WHERE id=? AND user_id=? AND status='rented'
            FOR UPDATE
        ");
        $stmt->bind_param("ii", $rental_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            throw new Exception("Rental not found or already returned.");
        }

        $equipment_id = $row['equipment_id'];

        $updateRental = $conn->prepare("
            UPDATE rental_table 
            SET status='returned', return_date=NOW() 
            WHERE id=? AND user_id=?
        ");
        $updateRental->bind_param("ii", $rental_id, $user_id);
        $updateRental->execute();

        $updateStock = $conn->prepare("
            UPDATE equipment_table 
            SET stock = stock + 1 
            WHERE id=?
        ");
        $updateStock->bind_param("i", $equipment_id);
        $updateStock->execute();

        /* 4. FIX STATUS PROPERLY (THIS IS THE IMPORTANT FIX) */
        $fixStatus = $conn->prepare("
            UPDATE equipment_table 
            SET status = CASE 
                WHEN stock > 0 THEN 'available'
                ELSE 'unavailable'
            END
            WHERE id=?
        ");
        $fixStatus->bind_param("i", $equipment_id);
        $fixStatus->execute();

        $conn->commit();
        $message = "Equipment returned successfully!";

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

<title>Return Equipment | FavyHairs</title>

<link rel="stylesheet" href="../css/style_4.css">
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

<h2>Return Equipment</h2>

<p>Welcome, <?php echo htmlspecialchars($user_name); ?></p>

<?php
if (!empty($message)) {
    echo "<p style='color:green;font-weight:bold;'>"
        . htmlspecialchars($message) .
    "</p>";
}
?>

<table>

<tr>
<th>Equipment</th>
<th>Rent Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$sql = "
SELECT r.id, e.name, r.rent_date, r.status
FROM rental_table r
JOIN equipment_table e ON r.equipment_id = e.id
WHERE r.user_id = $user_id AND r.status='rented'
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

<tr>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['rent_date']); ?></td>
<td><?php echo htmlspecialchars($row['status']); ?></td>

<td>
<form method="POST">
<input type="hidden" name="rental_id" value="<?php echo $row['id']; ?>">
<button type="submit" name="return">Return</button>
</form>
</td>

</tr>

<?php
    }

} else {
    echo "<tr><td colspan='4'>No rented equipment</td></tr>";
}

$conn->close();
?>

</table>

</div>

</body>
</html>