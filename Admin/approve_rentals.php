<?php
session_start();
include "../db_connect.php";

$conn = new mysqli("localhost", "root", "", "favyhairs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['approve']) && isset($_POST['id'])) {

    $rental_id = intval($_POST['id']);

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("SELECT equipment_id FROM rental_table WHERE id=?");
        if (!$stmt) throw new Exception("Prepare failed");

        $stmt->bind_param("i", $rental_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            throw new Exception("Rental not found");
        }

        $equipment_id = $row['equipment_id'];

        $updateRental = $conn->prepare(
            "UPDATE rental_table SET status='approved' WHERE id=?"
        );
        $updateRental->bind_param("i", $rental_id);
        $updateRental->execute();

        $stockUpdate = $conn->prepare(
            "UPDATE equipment_table SET stock = stock - 1 WHERE id=? AND stock > 0"
        );

        if ($stockUpdate) {
            $stockUpdate->bind_param("i", $equipment_id);
            $stockUpdate->execute();
        } else {
          
            $conn->query("UPDATE equipment_table SET status='unavailable' WHERE id=$equipment_id");
        }

        $conn->commit();
        $message = " Rental approved successfully!";

    } catch (Exception $e) {
        $conn->rollback();
        $message = " Error: " . $e->getMessage();
    }
}

$rentalStmt = $conn->prepare("SELECT 
    rental_table.id, 
    `user`.first_name, 
    equipment_table.name, 
    rental_table.rent_date, 
    rental_table.status
FROM rental_table
JOIN `user` ON rental_table.user_id = `user`.id
JOIN equipment_table ON rental_table.equipment_id = equipment_table.id
WHERE rental_table.rental_status = ?
");

$status = "pending";
$rentalStmt->bind_param("s", $status);
$rentalStmt->execute();

$Pendingresult = $rentalStmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/style_2.css">
<title>Approve Rentals</title>
</head>

<body>

<?php include "nav.php"; ?>

<div class="container">

<h3>Approve Rentals</h3>

<?php if (!empty($message)) echo "<p><b>$message</b></p>"; ?>

<table border="1">
<tr>
<th>User</th>
<th>Equipment</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php
if ($Pendingresult->num_rows > 0) {
    while ($row = $Pendingresult->fetch_assoc()) {
?>

<tr>
<td><?= htmlspecialchars($row['first_name']) ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['rent_date']) ?></td>
<td>
<form method="POST">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button type="submit" name="approve">Approve</button>
</form>
</td>
</tr>

<?php
    }
} else {
    echo "<tr><td colspan='4'>No pending rentals</td></tr>";
}
?>

</table>

</div>

</body>
</html>