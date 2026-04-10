<?php
session_start();
include "../db_connect.php"; 


if(isset($_POST['login'])) {

    $username = trim($_POST['username']); 
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {

        $user = $result->fetch_assoc();

       
        if(password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];

            if($user['role'] == "admin"){

                header("Location: ../Admin/admin_dashboard.php");
                exit();

            } else {

                header("Location: dashboard.php");
                exit();

            }

        } else {

            $error = "Incorrect password. Try again or use the 'Forgot Password' option.";

        }

    } else {

        $error = "User not found. You can register below.";

    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - FavyHairs</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="bodyContainer">

<div class="loginOverlay">

<div class="container">

<h2>Login</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<?php if(isset($_GET['msg'])) echo "<p class='success'>".$_GET['msg']."</p>"; ?>

<form method="POST" action="">

<input type="text" name="username" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<label for="role">Choose Role:</label>

<select name="role" required>
<option value="">Select Role</option>
<option value="admin">Admin</option>
<option value="user">User</option>
</select>

<button type="submit" name="login">Login</button>

</form>

<p style="text-align:center; color:#555; margin:15px 0;">
Please register if you don't have an account.
</p>

<div class="links">

<a href="register.php">Register</a>

<a href="forgot_password.php">Forgot Password?</a>

</div>

</div>

</div>

</div>

</body>

</html>