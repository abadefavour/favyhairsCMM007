<?php
session_start();
include "../db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SESSION['user_id'] = 1;
$_SESSION['role'] = "admin";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
    header("Location: /FAVYHAIRS/User/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/style_2.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    
    <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="add_equipment.php">Add Equipment</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="approve_rentals.php">Approve Rentals</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="approve_returns.php">Approve Returns</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="manage_users.php">Manage Users</a>
        </li>

      </ul>

      <form method="POST" action="../User/logout.php" class="d-flex">
        <button class="btn btn-danger">Logout</button>
      </form>

    </div>
  </div>
</nav>

<div class="container mt-4">

    <h2>Welcome Admin</h2>
    <p>Select an action from the menu.</p>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Dashboard</h5>
                    <p class="card-text">View system overview.</p>
                    <a href="admin_dashboard.php" class="btn btn-dark">Go</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Add Equipment</h5>
                    <p class="card-text">Add new equipment.</p>
                    <a href="add_equipment.php" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Approve Rentals</h5>
                    <p class="card-text">Review rentals.</p>
                    <a href="approve_rentals.php" class="btn btn-success">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Approve Returns</h5>
                    <p class="card-text">Check returns.</p>
                    <a href="approve_returns.php" class="btn btn-warning">Check</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Control users.</p>
                    <a href="manage_users.php" class="btn btn-info">Manage</a>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>