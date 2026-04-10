<?php
session_start();
include "../db_connect.php";

$conn = new mysqli("localhost", "root", "", "favyhairs");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['first_name'] ?? "User";
$message = "";

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_POST['select_item'])) {
    $_SESSION['equipment_id'] = intval($_POST['equipment_id']);
    $_SESSION['amount'] = floatval($_POST['price']);
}

if (isset($_POST['pay'])) {

    if (!isset($_SESSION['equipment_id'], $_SESSION['amount'])) {
        $message = "Session expired. Please try again.";
    } elseif (empty($_POST['payment_method'])) {
        $message = "Please select a payment method.";
    } else {

        $equipment_id = $_SESSION['equipment_id'];
        $amount = $_SESSION['amount'];
        $method = $_POST['payment_method'];

        $conn->begin_transaction();

        try {

            $check = $conn->prepare("SELECT stock FROM equipment_table WHERE id=? FOR UPDATE");
            $check->bind_param("i", $equipment_id);
            $check->execute();
            $result = $check->get_result();
            $row = $result->fetch_assoc();

            if (!$row || $row['stock'] <= 0) {
                throw new Exception("Equipment not available");
            }

            $update = $conn->prepare("UPDATE equipment_table SET stock = stock - 1 WHERE id=?");
            $update->bind_param("i", $equipment_id);
            $update->execute();

            $rental = $conn->prepare(
                "INSERT INTO rental_table (equipment_id, user_id, rent_date, status)
                 VALUES (?, ?, CURDATE(), 'rented')"
            );
            $rental->bind_param("ii", $equipment_id, $user_id);
            $rental->execute();

            $payment = $conn->prepare(
                "INSERT INTO payments (user_id, equipment_id, amount, payment_method, payment_status, reference)
                 VALUES (?, ?, ?, ?, 'paid', ?)"
            );

            $reference = "PAY_" . time() . "_" . $user_id;

            $payment->bind_param("iidss", $user_id, $equipment_id, $amount, $method, $reference);
            $payment->execute();

            $conn->commit();

            $message = " Payment successful! Equipment rented.";

            unset($_SESSION['equipment_id'], $_SESSION['amount']);

        } catch (Exception $e) {
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>FavyHairs Rental</title>
<link rel="stylesheet" href="../css/style_4.css">
</head>

<body>

<nav>
<a href="profile.php">Profile</a>

<form method="POST" style="display:inline;">
<button type="submit" name="logout">Logout</button>
</form>
</nav>

<h2>Welcome <?php echo htmlspecialchars($user_name); ?></h2>

<?php if (!empty($message)) echo "<p><b>$message</b></p>"; ?>

<?php if (isset($_SESSION['equipment_id'])) { ?>

<h3>Select Payment Method</h3>

<form method="POST">
    <select name="payment_method" required>
        <option value="">--Choose--</option>
        <option value="card">Card</option>
        <option value="palmpay">PalmPay</option>
        <option value="bank">Bank Transfer</option>
    </select>

    <button type="submit" name="pay">Confirm Payment</button>
</form>

<?php } else { ?>

<h3>Available Equipment</h3>

<table border="1">
<tr>
<th>Name</th>
<th>Price</th>
<th>Stock</th>
<th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM equipment_table WHERE stock > 0");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

<tr>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td>$<?php echo htmlspecialchars($row['price_per_day']); ?></td>
<td><?php echo htmlspecialchars($row['stock']); ?></td>

<td>
<form method="POST">
    <input type="hidden" name="equipment_id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="price" value="<?php echo $row['price_per_day']; ?>">
    <button type="submit" name="select_item">Rent</button>
</form>
</td>
</tr>

<?php
    }
} else {
    echo "<tr><td colspan='4'>No equipment available</td></tr>";
}
?>

</table>

<?php } ?>

<link rel="stylesheet" href="dashboard.php">

</body>
</html>