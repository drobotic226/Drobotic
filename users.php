<?php 
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>All Registered Users</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="p-6">
    <h2 class="text-3xl font-bold mb-6">All Registered Users</h2>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-700">
                <tr>
                    <th class="py-2 px-3 text-gray-300 border">Customer ID</th>
                    <th class="py-2 px-3 text-gray-300 border">Full Name</th>
                    <th class="py-2 px-3 text-gray-300 border">Email</th>
                    <th class="py-2 px-3 text-gray-300 border">Phone</th>
                    <th class="py-2 px-3 text-gray-300 border">Registration Date</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");

                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_assoc($query)){
                        // Format customer ID
                        $year = date('Y'); // current year
                        $customer_id = sprintf("DRB-CUST-%s-%04d", $year, $row['id']); 
                        // %04d pads numeric ID with leading zeros, e.g., 1 -> 0001

                        echo "
                        <tr class='border-b border-gray-700'>
                            <td class='py-2 px-3'>{$customer_id}</td>
                            <td class='py-2 px-3'>{$row['name']}</td>
                            <td class='py-2 px-3'>{$row['email']}</td>
                            <td class='py-2 px-3'>{$row['mobile']}</td>
                            <td class='py-2 px-3'>{$row['created_at']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-3'>No Users Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
