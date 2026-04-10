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
    <link rel="stylesheet" href="../css/style_2.css">
</head>

<body>

<?php include "nav.php"; ?>

<div class="container">

<h3>Manage Users</h3>

<form method="POST">
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit" name="add_user">Add User</button>
</form>

<br>

<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Actions</th>
</tr>

<?php while($row = $users->fetch_assoc()){ ?>
<tr>

<form method="POST">

<td>
    <input type="text" name="first_name" value="<?= $row['first_name'] ?>">
</td>

<td>
    <input type="email" name="email" value="<?= $row['email'] ?>">
</td>

<td>
    <select name="role">
        <option value="user" <?= $row['role']=="user" ? "selected" : "" ?>>User</option>
        <option value="admin" <?= $row['role']=="admin" ? "selected" : "" ?>>Admin</option>
    </select>
</td>

<td>
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    <button type="submit" name="update">Update</button>

</form>

<form method="POST" style="display:inline;">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit" name="delete">Delete</button>
</form>

</td>

</tr>
<?php } ?>

</table>

</div>
</body>
</html>