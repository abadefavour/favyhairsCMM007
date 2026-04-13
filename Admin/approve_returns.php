<?php
session_start();
include "../db_connect.php";

$return = $conn->query("
SELECT 
    rental_table.id, 
    `user`.first_name, 
    equipment_table.name, 
    rental_table.rent_date, 
    rental_table.status
FROM rental_table
JOIN `user` ON rental_table.user_id = `user`.id
JOIN equipment_table ON rental_table.equipment_id = equipment_table.id
WHERE rental_table.status = 'returned'
");

if (!$return) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

    <div>
        <?php include_once '../include/admin-header.php'; ?>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Approve Returns</h3>
                <p class="text-gray-500 text-sm mt-1">Monitor returned equipment and status</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Equipment</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        <?php if ($return->num_rows > 0) { ?>
                            <?php while($row = $return->fetch_assoc()){ ?>

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

                            <td class="px-6 py-4">
                                <?php
                                $status = strtolower($row['status']);
                                $statusClass = "bg-gray-100 text-gray-700";

                                if ($status === "approved") {
                                    $statusClass = "bg-green-100 text-green-700";
                                } elseif ($status === "pending") {
                                    $statusClass = "bg-yellow-100 text-yellow-700";
                                } elseif ($status === "rejected") {
                                    $statusClass = "bg-red-100 text-red-700";
                                }
                                ?>

                                <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $statusClass ?>">
                                <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>

                            </tr>

                            <?php } ?>
                        <?php } else { ?>

                            <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                No return records found
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