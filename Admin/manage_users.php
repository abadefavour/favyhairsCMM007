<?php
session_start();
include "../db_connect.php";

if(isset($_POST['add_user'])){
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $conn->query("
        INSERT INTO user (first_name, email, password, role)
        VALUES ('$first_name', '$email', '$password', '$role')
    ");
}

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $conn->query("DELETE FROM user WHERE id='$id'");
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $conn->query("
        UPDATE user 
        SET first_name='$first_name', email='$email', role='$role'
        WHERE id='$id'
    ");
}

$users = $conn->query("SELECT * FROM user");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<div class="min-h-screen bg-gray-50">
  <?php include_once '../include/admin-header.php'; ?>

  <div class="max-w-6xl mx-auto p-6">

    <!-- Page Title -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Users</h1>

    <!-- Add User Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
      <h2 class="text-lg font-semibold mb-4">Add New User</h2>

      <form method="POST" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        
        <input type="text" name="first_name" placeholder="First Name" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none">

        <input type="email" name="email" placeholder="Email" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none">

        <input type="password" name="password" placeholder="Password" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none">

        <select name="role"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>

        <div class="md:col-span-2 lg:col-span-4">
          <button type="submit" name="add_user"
            class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg transition">
            Add User
          </button>
        </div>

      </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">

        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
              <th class="px-6 py-3">Name</th>
              <th class="px-6 py-3">Email</th>
              <th class="px-6 py-3">Role</th>
              <th class="px-6 py-3 text-right">Actions</th>
            </tr>
          </thead>

          <tbody class="divide-y">

            <?php while($row = $users->fetch_assoc()){ ?>
            <tr class="hover:bg-gray-50">

              <form method="POST" class="contents">

                <!-- Name -->
                <td class="px-6 py-4">
                  <input type="text" name="first_name"
                    value="<?= $row['first_name'] ?>"
                    class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-1 focus:ring-pink-500 outline-none">
                </td>

                <!-- Email -->
                <td class="px-6 py-4">
                  <input type="email" name="email"
                    value="<?= $row['email'] ?>"
                    class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-1 focus:ring-pink-500 outline-none">
                </td>

                <!-- Role -->
                <td class="px-6 py-4">
                  <select name="role"
                    class="border border-gray-300 rounded-lg px-2 py-1 focus:ring-1 focus:ring-pink-500 outline-none">
                    <option value="user" <?= $row['role']=="user" ? "selected" : "" ?>>User</option>
                    <option value="admin" <?= $row['role']=="admin" ? "selected" : "" ?>>Admin</option>
                  </select>
                </td>

                <!-- Actions -->
                <td class="px-6 py-4 text-right space-x-2">

                  <input type="hidden" name="id" value="<?= $row['id'] ?>">

                  <button type="submit" name="update"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
                    Update
                  </button>

              </form>

              <form method="POST" class="inline">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <button type="submit" name="delete"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                  Delete
                </button>
              </form>

                </td>

            </tr>
            <?php } ?>

          </tbody>
        </table>

      </div>
    </div>

  </div>
</div>

</body>
</html>