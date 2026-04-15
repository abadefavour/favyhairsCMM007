<?php
session_start();
include "../db_connect.php";

$error = "";


if(isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        $_SESSION['reset_user_id'] = $user['id'];

        header("Location: ../create_password.php");
        exit();

    } else {
        $error = "Email not found. Please check or register.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password - FavyHairs</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h2>Forgot Password</h2>

    <?php if($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit" name="submit">Proceed</button>
    </form>

    <div class="links">
        <a href="../auth/login.php">Back to Login</a>
        <a href="../auth/register.php">Register</a>
    </div>
</div>

</body>
</html>