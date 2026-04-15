<?php
session_start();
include "db_connect.php";

$error = $success = "";

if(!isset($_SESSION['reset_user_id'])) {
    header("Location: ../forgot_password.php");
    exit();
}

$user_id = $_SESSION['reset_user_id'];

if(isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password !== $confirm_password){
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE user SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed_password, $user_id);

        if($stmt->execute()){
            $success = "Password successfully updated! <a href='index.php'>Login</a>";
            unset($_SESSION['reset_user_id']); 
        } else {
            $error = "Error updating password. Try again.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create New Password - FavyHairs</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h2>Create New Password</h2>

    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <?php if($success) echo "<p class='success'>$success</p>"; ?>

    <?php if(!$success) { ?>
    <form method="POST" action="">
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" name="submit">Set Password</button>
    </form>
    <?php } ?>
</div>

</body>
</html>