<?php
session_start();
include "../db_connect.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['approve']) && isset($_POST['id'])) {

    $rental_id = intval($_POST['id']);

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("SELECT equipment_id FROM rental_table WHERE id=?");
        if (!$stmt) throw new Exception("Prepare failed");

        $stmt->bind_param("i", $rental_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            throw new Exception("Rental not found");
        }

        $equipment_id = $row['equipment_id'];

        $updateRental = $conn->prepare(
            "UPDATE rental_table SET status='approved' WHERE id=?"
        );
        $updateRental->bind_param("i", $rental_id);
        $updateRental->execute();

        $stockUpdate = $conn->prepare(
            "UPDATE equipment_table SET stock = stock - 1 WHERE id=? AND stock > 0"
        );

        if ($stockUpdate) {
            $stockUpdate->bind_param("i", $equipment_id);
            $stockUpdate->execute();
        } else {
          
            $conn->query("UPDATE equipment_table SET status='unavailable' WHERE id=$equipment_id");
        }

        $conn->commit();
        $message = " Rental approved successfully!";

    } catch (Exception $e) {
        $conn->rollback();
        $message = " Error: " . $e->getMessage();
    }
}

$rentalStmt = $conn->prepare("SELECT 
    rental_table.id, 
    `user`.first_name, 
    equipment_table.name, 
    rental_table.rent_date, 
    rental_table.status
FROM rental_table
JOIN `user` ON rental_table.user_id = `user`.id
JOIN equipment_table ON rental_table.equipment_id = equipment_table.id
WHERE rental_table.rental_status = ?
");

$status = "pending";
$rentalStmt->bind_param("s", $status);
$rentalStmt->execute();

$Pendingresult = $rentalStmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<title>Approve Rentals</title>
</head>

<body>

<div>
    <div>
        <?php include_once '../include/admin-header.php'; ?>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Approve Rentals</h3>
                <p class="text-gray-500 text-sm mt-1">Review and approve pending rental requests</p>
            </div>
            <?php if (!empty($message)) { ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                <?php echo $message; ?>
            </div>
            <?php } ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Equipment</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                    <tbody class="divide-y divide-gray-100">

                    <?php
                    if ($Pendingresult->num_rows > 0) {
                        while ($row = $Pendingresult->fetch_assoc()) {
                    ?>

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 font-medium text-gray-800">
                        <?= htmlspecialchars($row['first_name']) ?>
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                        <?= htmlspecialchars($row['name']) ?>
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                        <?= htmlspecialchars($row['rent_date']) ?>
                        </td>

                        <td class="px-6 py-4 text-right">

                        <form method="POST" class="inline">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                            <button type="submit" name="approve"
                            class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transition shadow-sm hover:shadow">
                            Approve
                            </button>
                        </form>

                        </td>
                    </tr>

                    <?php
                        }
                    } else {
                    ?>

                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                        No pending rentals
                        </td>
                    </tr>

                    <?php } ?>

                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>