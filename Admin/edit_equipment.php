<?php
session_start();
include "../db_connect.php";

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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

    <div>
        <?php include_once '../include/admin-header.php'; ?>
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200 px-4 py-10">
            <div class="w-full max-w-2xl">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-bold text-gray-800">Edit Equipment</h2>
                        <p class="text-gray-500 text-sm mt-2">
                            Update the details of this equipment item
                        </p>
                    </div>
                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                            Equipment Name
                            </label>
                            <input type="text" name="name"
                            value="<?= htmlspecialchars($equipment['name']) ?>"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                            required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                            </label>
                            <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"><?= htmlspecialchars($equipment['description']) ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stock Quantity
                            </label>
                            <input type="number" name="stock"
                            value="<?= htmlspecialchars($equipment['stock']) ?>"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                            required>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit" name="update"
                            class="w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl font-semibold transition shadow-md hover:shadow-lg">
                            Update Equipment
                            </button>
                            <a href="manage_equipment.php"
                            class="w-full sm:w-auto text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                            Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>