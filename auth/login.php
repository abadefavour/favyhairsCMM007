<?php
session_start();
include "../db_connect.php"; 


if(isset($_POST['login'])) {
    $username = trim($_POST['username']); 
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            if($role == "admin"){
                header("Location: ../Admin/admin_dashboard.php");
                exit();
            } else {
                header("Location: ../user/dashboard.php");
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
<script src="https://cdn.tailwindcss.com"></script>
<link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>
<body class="bg-gray-100">
  <div>
    <?php include_once '../include/header.php'; ?>
    <div class="min-h-screen flex items-center justify-center relative">
      <div class="absolute inset-0">
        <img src="../images/hero_bg.jpeg" class="w-full h-full object-cover">
      </div>
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 bg-white rounded-xl shadow-lg w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
          Welcome Back
        </h2>
        <p class="text-gray-500 text-center mb-6">
          Login to continue renting
        </p>
        <?php if(isset($error)) { ?>
          <div class="mb-4 text-sm text-red-500 text-center">
            <?php echo $error; ?>
          </div>
        <?php } ?>
        <!-- Success Message -->
        <?php if(isset($_GET['msg'])) { ?>
          <div class="mb-4 text-sm text-green-500 text-center">
            <?php echo $_GET['msg']; ?>
          </div>
        <?php } ?>
        <!-- Form -->
        <form method="POST" class="space-y-4">
          <input type="text" name="username" placeholder="Email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
          <input type="password" name="password" placeholder="Password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
          <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
          <button type="submit" name="login"
            class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-lg font-medium transition shadow">
            Login
          </button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-500">
          <p>
            Don’t have an account?
            <a href="register.php" class="text-pink-500 font-medium hover:underline">Register</a>
          </p>
          <a href="../user/forget_password.php" class="block mt-2 text-gray-400 hover:text-pink-500 transition">
            Forgot Password?
          </a>
        </div>
      </div>
    </div>
    <?php include_once '../include/footer.php' ?>
  </div>
</body>
</html>