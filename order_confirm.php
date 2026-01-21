<?php
session_start();
include "db.php";  // database connection

$products = [
    ["name"=>"Class M15","price"=>"₹150","image"=>"images/312489_nz9ucg.png","company"=>"Eureka Forbes"], 
    ["name"=>"Euroclean Glide","price"=>"₹120","image"=>"images/312756_h1yc9m.png","company"=>"Eureka Forbes"],
    ["name"=>"Decker Vacuum","price"=>"₹180","image"=>"images/312488_bvgyqz.png","company"=>"Black & Decker"],
    ["name"=>"Karcher 2","price"=>"₹200","image"=>"images/312489_nz9ucg.png","company"=>"Karcher"],
    ["name"=>"Vacuum X","price"=>"₹160","image"=>"images/312756_h1yc9m.png","company"=>"Black & Decker"],
    ["name"=>"Cleaner Pro","price"=>"₹140","image"=>"images/312756_h1yc9m.png","company"=>"Karcher"],
    ["name"=>"SuperVac 3000","price"=>"₹250","image"=>"images/thumbnail_AUTOBIN_01_dc5df37216.jpg","company"=>"Eureka Forbes"],
    ["name"=>"DustBuster Pro","price"=>"₹300","image"=>"images/thumbnail_EFL_Auto_Bin_Banner_1_6a2dec8338_1_346bd9dd2c.jpg","company"=>"Black & Decker"],
];


// AUTO GENERATE ORDER ID
if (!isset($_GET['order_id'])) {
    $orderId = rand(100000, 999999);
    header("Location: confirm.php?order_id={$orderId}");
    exit;
}

$orderId = $_GET['order_id'];


// Validate session order
if (!isset($_SESSION['orders'][$orderId])) {
    die("Invalid order. Please place an order first.");
}


// Get order details
$order = $_SESSION['orders'][$orderId];
$items = $order['items'];
$timestamp = $order['timestamp'];
$payment = $order['payment_method'];


// Calculate total amount
$totalAmount = 0;
foreach ($items as $item) {
    $id = $item['id'];
    $quantity = intval($item['quantity']);
    if (isset($products[$id])) {
        $unitPrice = floatval(preg_replace('/[^\d.]/', '', $products[$id]['price']));
        $totalAmount += $unitPrice * $quantity;
    }
}


// =========================================
// SAVE ORDER TO DATABASE IF NOT ALREADY SAVED
// =========================================

// CHECK IF ORDER ALREADY EXISTS
$check = $conn->query("SELECT * FROM orders WHERE order_id='$orderId'");

if ($check->num_rows == 0) {

    // Insert into orders table
    $conn->query("
        INSERT INTO orders (order_id, order_date, payment_method, total_amount)
        VALUES ('$orderId', '$timestamp', '$payment', '$totalAmount')
    ");

    // Insert each item in order_items table
    foreach ($items as $item) {
        $id = $item['id'];
        $quantity = intval($item['quantity']);
        $unitPrice = floatval(preg_replace('/[^\d.]/','',$products[$id]['price']));

        $productName = $products[$id]['name'];
        $company = $products[$id]['company'];

        $conn->query("
            INSERT INTO order_items (order_id, product_name, company, quantity, unit_price)
            VALUES ('$orderId', '$productName', '$company', '$quantity', '$unitPrice')
        ");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Order Confirmation</title>
<style>
body { font-family: Arial, sans-serif; background:#f7f7f7; padding:20px; }
.container { max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:8px; text-align:center; }
h2 { color:green; }
.message-box {
    background:#e8ffe6;
    border-left:5px solid green;
    padding:15px;
    margin-top:20px;
    border-radius:5px;
    font-size:16px;
}
table { width:100%; border-collapse: collapse; margin-top:20px; }
table, th, td { border:1px solid #ddd; }
th, td { padding:10px; text-align:center; }
.total { font-weight:bold; font-size:18px; }
</style>
</head>
<body>
<div class="container">

    <h2>✅ Order Confirmed!</h2>

    <div class="message-box">
        🎉 <b>Order Confirmed!</b><br>
        Thank you for your payment!<br>
        <b>Your Order Number is <?= $orderId ?>.</b><br>
        You'll receive a shipping notification soon.
    </div>

    <p><b>Order Date:</b> <?= htmlspecialchars($timestamp) ?></p>
    <p><b>Payment Method:</b> <?= htmlspecialchars($payment) ?></p>

    <h3>Order Summary</h3>
    <table>
        <tr>
            <th>Product</th>
            <th>Company</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>

        <?php foreach ($items as $item): 
            $id = $item['id'];
            $quantity = intval($item['quantity']);
        ?>
        <tr>
            <td><?= htmlspecialchars($products[$id]['name']) ?></td>
            <td><?= htmlspecialchars($products[$id]['company']) ?></td>
            <td><?= $quantity ?></td>
            <td><?= $products[$id]['price'] ?></td>
        </tr>
        <?php endforeach; ?>

        <tr>
            <td colspan="3" class="total">Total</td>
            <td class="total">₹<?= number_format($totalAmount,2) ?></td>
        </tr>
    </table>

</div>
</body>
</html>
