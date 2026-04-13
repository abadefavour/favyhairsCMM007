<?php
session_start();
include "../db_connect.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="../css/style_2.css">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<div>
  <?php include_once '../include/admin-header.php'; ?>

  <div class="max-w-7xl mx-auto px-4 py-8">

    <div class="mb-8">
      <h2 class="text-3xl font-bold text-gray-800">Welcome Admin</h2>
      <p class="text-gray-500 mt-1">Select an action from the menu.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

      <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-800">Dashboard</h5>
        <p class="text-gray-500 mt-2">View system overview.</p>
        <a href="admin_dashboard.php"
           class="inline-block mt-4 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
          Go
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-800">Add Equipment</h5>
        <p class="text-gray-500 mt-2">Add new equipment.</p>
        <a href="add_equipment.php"
           class="inline-block mt-4 bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
          Add
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-800">Manage Equipment</h5>
        <p class="text-gray-500 mt-2">Edit, delete or view equipment.</p>
        <a href="manage_equipment.php"
           class="inline-block mt-4 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
          Manage
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-800">Approve Rentals</h5>
        <p class="text-gray-500 mt-2">Review rentals.</p>
        <a href="approve_rentals.php"
           class="inline-block mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
          View
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-800">Approve Returns</h5>
        <p class="text-gray-500 mt-2">Check returns.</p>
        <a href="approve_returns.php"
           class="inline-block mt-4 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
          Check
        </a>
      </div>

      <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-800">Manage Users</h5>
        <p class="text-gray-500 mt-2">Control users.</p>
        <a href="manage_users.php"
           class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
          Manage
        </a>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>