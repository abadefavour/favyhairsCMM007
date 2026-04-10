<?php
session_start();
require_once "../db_connect.php";

if (!isset($_SESSION['role']) || empty($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$message = "";

if (isset($_POST['register'])) {

    $first_name   = trim($_POST['first_name'] ?? '');
    $last_name    = trim($_POST['last_name'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $password     = $_POST['password'] ?? '';
    $role         = $_SESSION['role'];
    $admin_key    = trim($_POST['admin_key'] ?? '');


    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $message = "<p style='color:red;'>Please fill in all required fields.</p>";
    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p style='color:red;'>Invalid email format.</p>";
    }

    elseif ($role === "admin" && $admin_key !== "favy_2026") {
        $message = "<p style='color:red;'>Invalid Admin Key.</p>";
    }

    else {
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "<p style='color:red;'>Email already exists.</p>";
            $stmt->close();
        } else {
            $stmt->close();

          
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO user (first_name, last_name, email, password, role, phone_number)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssssss",
                $first_name,
                $last_name,
                $email,
                $hashed_password,
                $role,
                $phone_number
            );

            if ($stmt->execute()) {
                unset($_SESSION['role']);
                header("Location: login.php?success=registered");
                exit();
            } else {
                $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FavyHairs - Register</title>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>

<div class="bodyContainer">

<div class="loginOverlay">

<div class="container">

<h3>Register <?php echo ucfirst($_SESSION['role']); ?></h3>

<form method="POST">

<input type="text" name="first_name" placeholder="First Name" required>

<input type="text" name="last_name" placeholder="Last Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="text" name="phone_number" placeholder="Phone Number">

<input type="password" name="password" placeholder="Password" required>

<?php
if($_SESSION['role'] == "admin"){
?>
<input type="text" name="admin_key" placeholder="Enter Admin Key" required>
<?php
}
?>

<button type="submit" name="register">Register</button>

</form>

<div class="login-link">

<p>If you already have an account</p>

<div class="links">

<a href="login.php" class="links">Login</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>