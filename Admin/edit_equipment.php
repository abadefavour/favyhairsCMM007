<?php
session_start();
include "../db_connect.php";

$conn = new mysqli("localhost", "root", "", "favyhairs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* 🔐 Admin check */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
    header("Location: /FAVYHAIRS/User/login.php");
    exit();
}

/* 🔍 Validate ID */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

/* 📦 Fetch equipment */
$stmt = $conn->prepare("SELECT * FROM equipment_table WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$equipment = $result->fetch_assoc();

if (!$equipment) {
    die("Equipment not found");
}

/* ✏️ Update equipment */
if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $stock = intval($_POST['stock']);

    $update = $conn->prepare(
        "UPDATE equipment_table SET name=?, description=?, stock=? WHERE id=?"
    );

    $update->bind_param("ssii", $name, $description, $stock, $id);

    if ($update->execute()) {
        header("Location: manage_equipment.php");
        exit();
    } else {
        echo "Error updating equipment.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Equipment</title>
    <link rel="stylesheet" href="../css/style_5.css">
</head>

<body>

<?php include "nav.php"; ?>

<div class="container">

    <h2>Edit Equipment</h2>

    <form method="POST" class="form-box">

        <label>Name</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($equipment['name']) ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($equipment['description']) ?></textarea>

        <label>Stock</label>
        <input type="number" name="stock"
               value="<?= htmlspecialchars($equipment['stock']) ?>" required>

        <button type="submit" name="update">Update Equipment</button>

    </form>

</div>

</body>
</html>