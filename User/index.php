<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "../db_connect.php";

if (isset($_POST['role']) && !empty($_POST['role'])) {

    $role = trim($_POST['role']);

    $_SESSION['role'] = $role;

    if ($role === "admin" || $role === "user") {
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FavyHairs</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container">

<h3>Create User Login</h3>

<form method="POST">

<label for="role">Choose Role:</label>

<select name="role" required>
<option value="">Select Role</option>
<option value="admin">Admin</option>
<option value="user">User</option>
</select>

<br><br>

<input type="submit" value="Continue">

</form>

</div>

</body>
</html>