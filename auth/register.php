<?php
session_start();
require_once "../db_connect.php";

// if (isset($_SESSION['user_id'])) {
//     header("Location: ../index.php");
//     exit();
// }

$message = "";

if (isset($_POST['register'])) {
    $first_name   = trim($_POST['first_name'] ?? '');
    $last_name    = trim($_POST['last_name'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $password     = trim($_POST['password']) ?? '';
    $role         = trim($_POST['role']);
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
<link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div>
        <?php include_once '../include/header.php' ?>
        <div class="min-h-screen flex items-center justify-center relative">
            <div class="absolute inset-0">
                <img src="../images/hero_bg.jpeg" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative z-10 bg-white rounded-xl shadow-lg w-full max-w-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
                Register with FavyHair
                </h2>
                <p class="text-gray-500 text-center mb-6">
                Create your account to start renting
                </p>
                <?php if (!empty($message)) { ?>
                <div class="mb-4 text-sm text-red-500 text-center">
                    <?php echo $message; ?>
                </div>
                <?php } ?>
                <form method="POST" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="first_name" placeholder="First Name"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                    <input type="text" name="last_name" placeholder="Last Name"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                </div>
                <input type="email" name="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                <input type="text" name="phone_number" placeholder="Phone Number"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400">
                <input type="password" name="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                <div>
                    <select name="role" id="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                        <option value="">Select a role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" name="register"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-lg font-medium transition shadow">
                    Register
                </button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="login.php" class="text-pink-500 hover:underline font-medium">Login</a>
                </p>
            </div>
        </div>
        <?php include_once '../include/footer.php' ?>
    </div>
</body>
</html>