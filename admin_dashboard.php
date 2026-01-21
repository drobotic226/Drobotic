<?php 
include("db.php");

// Dynamic values (replace with DB values if needed)
$total_users = 1560;
$total_orders = 1140;
$total_products = 7560;
$revenue = 24300;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-VU4v...yourhash..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-900 text-white">

<div class="flex">

   <!-- SIDEBAR -->
<aside class="w-64 bg-gray-900 text-white min-h-screen relative">

    <!-- Logo -->
    <div class="p-6 text-2xl font-bold border-b border-gray-700">
        Admin Panel
    </div>

    <!-- MAIN MENU -->
    <nav class="p-4 space-y-3">

        <a href="users.php" class="block p-2 rounded hover:bg-gray-700">
            <i class="fas fa-users text-blue-400"></i> Users
        </a>

        <a href="orders.php" class="block p-2 rounded hover:bg-gray-700">
            <i class="fas fa-box text-yellow-400"></i> Orders
        </a>

        <a href="add_product.php" class="block p-2 rounded hover:bg-gray-700">
            <i class="fas fa-shopping-cart text-green-400"></i> Products
        </a>

    </nav>


    <!-- SETTINGS DROPDOWN BUTTON -->
    <div class="absolute bottom-10 w-full px-4">
        <button onclick="toggleSettings()" 
            class="hover:text-gray-300 w-full text-left text-lg flex items-center justify-between">
            <span><i class="fas fa-cog text-purple-400"></i> Settings</span>
            <span id="arrowIcon">▼</span>
        </button>

        <!-- DROPDOWN MENU -->
        <div id="settingsMenu" class="hidden mt-3 ml-3 space-y-2">

            <a href="settings_profile.php" 
               class="flex items-center gap-2 p-2 rounded hover:bg-gray-700">
                <i class="fas fa-user text-blue-400"></i> Profile Settings
            </a>

            <a href="settings_password.php" 
               class="flex items-center gap-2 p-2 rounded hover:bg-gray-700">
                <i class="fas fa-lock text-red-400"></i> Change Password
            </a>

            <a href="settings_notifications.php" 
               class="flex items-center gap-2 p-2 rounded hover:bg-gray-700">
                <i class="fas fa-bell text-yellow-400"></i> Notification Settings
            </a>

            <a href="settings_general.php" 
               class="flex items-center gap-2 p-2 rounded hover:bg-gray-700">
                <i class="fas fa-cogs text-purple-400"></i> General Settings
            </a>

            <a href="logout.php" 
               class="flex items-center gap-2 p-2 rounded hover:bg-red-600">
                <i class="fas fa-sign-out-alt text-red-500"></i> Logout
            </a>

        </div>
    </div>
</aside>

<!-- JS FOR DROPDOWN -->
<script>
function toggleSettings() {
    const menu = document.getElementById("settingsMenu");
    const arrow = document.getElementById("arrowIcon");

    if (menu.classList.contains("hidden")) {
        menu.classList.remove("hidden");
        arrow.textContent = "▲";
    } else {
        menu.classList.add("hidden");
        arrow.textContent = "▼";
    }
}
</script>

<!-- MAIN CONTENT -->
<main class="flex-1 p-8">

    <!-- TOP CARDS -->
    <div class="grid grid-cols-4 gap-6 mb-6">

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <p class="text-gray-400">Total Users</p>
            <h2 class="text-3xl font-bold"><?php echo $total_users ?></h2>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <p class="text-gray-400">Total Orders</p>
            <h2 class="text-3xl font-bold"><?php echo $total_orders ?></h2>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <p class="text-gray-400">Total Products</p>
            <h2 class="text-3xl font-bold"><?php echo $total_products ?></h2>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <p class="text-gray-400">Revenue</p>
            <h2 class="text-3xl font-bold">$<?php echo $revenue ?></h2>
        </div>

    </div>

    <!-- CUSTOMER ORDERS TABLE -->
    <?php 
    $orders = [
        ["name" => "John Doe", "product" => "Laptop", "date" => "01 Jan 2024", "status" => "Delivered", "tracking" => "Delivered at 10 AM"],
        ["name" => "Alicia Smith", "product" => "Smartphone", "date" => "24 Dec 2023", "status" => "Pending", "tracking" => "Order is being processed"],
        ["name" => "Michael Lee", "product" => "Headphones", "date" => "18 Dec 2023", "status" => "Shipped", "tracking" => "Shipped via UPS"],
    ];

    $customerNumber = 1;
    $year = date("Y");
    ?>

    <div class="grid grid-cols-1 gap-6 mt-6">
        <div class="bg-gray-800 p-6 rounded-xl shadow-xl">

            <h3 class="text-xl font-semibold mb-4">Customer Orders</h3>

            <table class="w-full border-collapse text-left">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="py-2 px-3 border">Customer ID</th>
                        <th class="py-2 px-3 border">Name</th>
                        <th class="py-2 px-3 border">Product</th>
                        <th class="py-2 px-3 border">Date</th>
                        <th class="py-2 px-3 border">Status</th>
                        <th class="py-2 px-3 border">Message</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($orders as $order): ?>
                    <?php
                        $customerID = "DRB-CUST-$year-" . sprintf("%04d", $customerNumber);

                        $status = $order['status'];
                        $color = "bg-gray-600";

                        if ($status == "Delivered") $color = "bg-green-600";
                        elseif ($status == "Pending") $color = "bg-yellow-600";
                        elseif ($status == "Shipped") $color = "bg-blue-600";

                        $statusID = "status-" . $customerNumber;
                    ?>

                    <tr class="border-b border-gray-700">

                        <td class="py-3 px-3"><?php echo $customerID; ?></td>
                        <td class="py-3 px-3"><?php echo $order['name']; ?></td>
                        <td class="py-3 px-3"><?php echo $order['product']; ?></td>
                        <td class="py-3 px-3"><?php echo $order['date']; ?></td>

                        <td class="py-3 px-3">
                            <button onclick="toggleTracking('<?php echo $statusID; ?>')" 
                                    class="<?php echo $color; ?> px-3 py-1 rounded-full text-sm">
                                <?php echo $status; ?>
                            </button>

                            <div id="<?php echo $statusID; ?>" 
                                 class="mt-2 p-2 bg-gray-700 rounded hidden text-sm">
                                <?php echo $order['tracking']; ?>
                            </div>
                        </td>

                        <td class="py-3 px-3">
                            <button onclick="openMsgBox('<?php echo $customerID; ?>',
                                                         '<?php echo $order['name']; ?>')"
                                    class="bg-purple-600 px-3 py-1 rounded text-sm">
                                Message
                            </button>
                        </td>

                    </tr>

                    <?php $customerNumber++; ?>
                <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

    <!-- MESSAGE POPUP -->
    <div id="messageBox" 
        class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-gray-800 p-6 rounded-xl w-96">

            <h2 class="text-xl font-bold mb-4">Send Message</h2>

            <p class="text-gray-300 mb-2">To: <span id="msgCustomer"></span></p>
            <p class="text-gray-400 mb-3 text-sm">Customer ID: <span id="msgCustomerID"></span></p>

            <textarea id="messageText" class="w-full p-2 bg-gray-700 rounded" rows="7"></textarea>

            <div class="flex justify-end space-x-3 mt-4">
                <button onclick="closeMsgBox()" class="px-3 py-1 bg-gray-600 rounded">Cancel</button>
                <button onclick="sendMessage()" class="px-3 py-1 bg-green-600 rounded">Send</button>
            </div>

        </div>
    </div>

</main>
</div>

<!-- JAVASCRIPT -->
<script>
function toggleTracking(id) {
    const box = document.getElementById(id);
    box.classList.toggle("hidden");
}

function openMsgBox(cid, name) {
    document.getElementById("msgCustomer").innerText = name;
    document.getElementById("msgCustomerID").innerText = cid;

    document.getElementById("messageText").value =
`DISPATCHED: Your Drobotic Order ${cid} is on its way.
Track your order here:
https://drobotic266.kesug.com/track.php?id=${cid}

Thank you,
Drobotic`;

    document.getElementById("messageBox").classList.remove("hidden");
}

function closeMsgBox() {
    document.getElementById("messageBox").classList.add("hidden");
}
</script>

</body>
</html>
