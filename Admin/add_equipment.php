<?php
session_start();
include "../db_connect.php";

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
    header("Location: ../auth/login.php");
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
<link rel="stylesheet" href="../css/style_2.css">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<div>
  <?php include '../include/admin-header.php'; ?>
   <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200 px-4 py-10">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div class="mb-8 text-center">
            <h3 class="text-3xl font-bold text-gray-800">
            Add Equipment
            </h3>
            <p class="text-gray-500 text-sm mt-2">
            Fill in the details to list a new rental item
            </p>
        </div>
        <!-- Error Message -->
        <?php if(!empty($message)) { ?>
            <div class="mb-6 flex items-start gap-3 text-sm text-red-700 bg-red-50 border border-red-200 px-4 py-3 rounded-xl">
            <span class="font-semibold">Error:</span>
            <span><?php echo $message; ?></span>
            </div>
        <?php } ?>
        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Equipment Name
                </label>
                <input type="text" name="equipment_name"
                    placeholder="e.g. Canon DSLR Camera"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"
                    required>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                    Price (per day)
                    </label>
                    <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">£</span>
                    <input type="number" step="0.01" name="price"
                        class="w-full pl-8 border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                Quantity
                </label>
                <input type="number" name="quantity"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
            </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Category
                </label>
                <input type="text" name="category"
                    placeholder="e.g. Camera, Tools, Electronics"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
            </div>
            <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Condition
            </label>
            <select name="condition"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
                <option value="">Select Condition</option>
                <option value="new">New</option>
                <option value="good">Good</option>
                <option value="fair">Fair</option>
                <option value="poor">Poor</option>
            </select>
            </div>
            <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea name="description" rows="4"
                placeholder="Provide details about the equipment..."
                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"></textarea>
            </div>
            <div class="pt-4">
            <button type="submit" name="add_equipment"
                class="w-full flex items-center justify-center gap-2 bg-pink-500 hover:bg-pink-600 text-white py-3 rounded-xl font-semibold transition shadow-md hover:shadow-lg">
                Add Equipment
            </button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>

</body>
</html>