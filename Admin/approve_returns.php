<?php
session_start();
include "../db_connect.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$return = $conn->query("
SELECT 
    rental_table.id, 
    `user`.first_name, 
    equipment_table.name, 
    rental_table.rent_date, 
    rental_table.status
FROM rental_table
JOIN `user` ON rental_table.user_id = `user`.id
JOIN equipment_table ON rental_table.equipment_id = equipment_table.id
WHERE rental_table.status = 'returned'
");

if (!$return) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/style_2.css">
</head>

<body>

<?php include "nav.php"; ?>

<div class="container">

<h3>Approve Returns</h3>

<table>
<tr>
<th>User</th>
<th>Equipment</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($row = $return->fetch_assoc()){ ?>
<tr>
<td><?= htmlspecialchars($row['first_name']) ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['rent_date']) ?></td>
<td><?= htmlspecialchars($row['status']) ?></td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>