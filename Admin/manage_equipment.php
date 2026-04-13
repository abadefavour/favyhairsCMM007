<?php
session_start();
include "../db_connect.php";

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
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<div>
    <?php include '../include/admin-header.php'; ?>
    <div class="max-w-7xl mx-auto px-4 py-8">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <h3 class="text-2xl font-bold text-gray-800">Manage Equipment</h3>

    <a href="add_equipment.php"
       class="inline-block bg-pink-500 hover:bg-pink-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow">
       + Add Equipment
    </a>
  </div>

  <!-- Message -->
  <?php if (!empty($message)) { ?>
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
      <?php echo $message; ?>
    </div>
  <?php } ?>

  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Stock</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                <?php
                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                ?>

                <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 text-gray-700">
                    <?= $row['id'] ?>
                </td>

                <td class="px-6 py-4 font-medium text-gray-800">
                    <?= htmlspecialchars($row['name']) ?>
                </td>

                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                    <?= htmlspecialchars($row['description']) ?>
                </td>

                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                    <?= $row['stock'] ?>
                    </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2">

                    <a href="edit_equipment.php?id=<?= $row['id'] ?>"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition">
                    Edit
                    </a>
                    <form method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="delete"
                        onclick="return confirm('Delete this equipment?');"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition">
                        Delete
                    </button>
                    </form>

                </td>
                </tr>

                <?php
                }
                } else {
                ?>

                <tr>
                <td colspan="5" class="text-center py-6 text-gray-500">
                    No equipment found
                </td>
                </tr>

                <?php } ?>

                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>