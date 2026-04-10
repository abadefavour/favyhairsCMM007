<?php
session_start();
include "../db_connect.php";

$conn = new mysqli("localhost", "root", "", "favyhairs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: /FAVYHAIRS/User/login.php");
    exit();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
    header("Location: /FAVYHAIRS/User/login.php");
    exit();
}

$message = "";

if (isset($_POST['delete']) && isset($_POST['id'])) {

    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM equipment_table WHERE id=?");

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Equipment deleted successfully!";
        } else {
            $message = "Error deleting equipment.";
        }
    } else {
        $message = "Prepare failed.";
    }
}

$result = $conn->query("SELECT * FROM equipment_table ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Equipment</title>
<link rel="stylesheet" href="../css/style_5.css">
</head>

<body>

<div style="background:#2c3e50; padding:10px;">
    <a href="admin_dashboard.php" style="color:white; margin-right:15px; text-decoration:none;">Dashboard</a>

    <form method="POST" style="display:inline;">
        <button type="submit" name="logout" style="background:#e74c3c; color:white; border:none; padding:5px 10px;">
            Logout
        </button>
    </form>
</div>

<div class="container">

<h3>Manage Equipment</h3>

<?php if (!empty($message)) echo "<p><b>$message</b></p>"; ?>

<a href="add_equipment.php">+ Add Equipment</a>
<br><br>

<table border="1">
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Stock</th>
<th>Action</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['description']) ?></td>
<td><?= $row['stock'] ?></td>

<td>

<a href="edit_equipment.php?id=<?= $row['id'] ?>">Edit</a>

<form method="POST" style="display:inline;">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit" name="delete" onclick="return confirm('Delete this equipment?');">
        Delete
    </button>
</form>

</td>
</tr>

<?php
    }
} else {
    echo "<tr><td colspan='5'>No equipment found</td></tr>";
}
?>

</table>

</div>

</body>
</html>