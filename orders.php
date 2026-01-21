<?php
session_start();
include("db.php");

// Get the logged-in user's email or mobile
$user = $_SESSION['auth_user'] ?? '';

// Fetch confirmed/delivered orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE (email=? OR mobile=?) AND status IN ('confirmed','delivered') ORDER BY order_date DESC");
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> DROBOTIC</title>
<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
header, footer { background:#333; color:#fff; text-align:center; padding:15px; }
.container { max-width: 1000px; margin: 30px auto; padding: 0 15px; }
h2 { text-align:center; margin-bottom:30px; }
.order-card { background:#fff; padding:20px; margin-bottom:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
.order-card h3 { margin-bottom:10px; color:#2874f0; }
.order-card p { margin:5px 0; }
.status-confirmed { color:green; font-weight:bold; }
.status-delivered { color:blue; font-weight:bold; }
.no-orders { text-align:center; color:#555; font-size:1.1rem; margin-top:50px; }

/* Delivery tracking */
.progress-container { background:#eee; border-radius:8px; overflow:hidden; height:20px; margin:10px 0; }
.progress-bar { height:100%; width:0%; background:#2874f0; text-align:center; color:#fff; line-height:20px; font-size:0.8rem; transition: width 0.5s; }
</style>
</head>
<body>

<header>
    <h1>My Orders</h1>
</header>

<div class="container">
    <h2>Your Orders</h2>

    <?php if(count($orders) == 0): ?>
        <p class="no-orders">You have no confirmed or delivered orders yet.</p>
    <?php else: ?>
        <?php foreach($orders as $order): ?>
            <div class="order-card">
                <h3>Order #<?= htmlspecialchars($order['id']) ?></h3>
                <p><strong>Product:</strong> <?= htmlspecialchars($order['product_name']) ?></p>
                <p><strong>Quantity:</strong> <?= htmlspecialchars($order['quantity']) ?></p>
                <p><strong>Price:</strong> <?= htmlspecialchars($order['price']) ?></p>
                <p><strong>Company:</strong> <?= htmlspecialchars($order['company']) ?></p>
                <p><strong>Status:</strong> 
                    <?php if($order['status']=='confirmed'): ?>
                        <span class="status-confirmed">Confirmed</span>
                    <?php elseif($order['status']=='delivered'): ?>
                        <span class="status-delivered">Delivered</span>
                    <?php endif; ?>
                </p>
                <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>

                <!-- Delivery Tracking -->
                <p><strong>Delivery Progress:</strong></p>
                <div class="progress-container">
                    <?php
                        // Example: convert delivery_status to percentage
                        $status = $order['delivery_status'] ?? 'Processing';
                        $percent = 0;
                        if($status == 'Processing') $percent=25;
                        elseif($status == 'Shipped') $percent=50;
                        elseif($status == 'Out for Delivery') $percent=75;
                        elseif($status == 'Delivered') $percent=100;
                    ?>
                    <div class="progress-bar" style="width:<?= $percent ?>%;"><?= htmlspecialchars($status) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<footer>
    &copy; 2025 DROBOTIC. All Rights Reserved.
</footer>

</body>
</html>
