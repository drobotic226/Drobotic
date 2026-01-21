<?php
session_start();

// Example products same as other pages
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

$orders = $_SESSION['orders'] ?? [];

if(empty($orders)){
    echo "<p>No orders found.</p>";
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>DROBOTIC</title>
<style>
/* General Reset */
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

/* Body */
body { background:#f4f6f8; color:#333; padding:20px; }

/* Container */
.container { max-width:1000px; margin:auto; }

/* Page Title */
.container h2 { text-align:center; margin-bottom:30px; color:#4b0082; }

/* Order Card */
.order-card { background:#fff; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.08); margin-bottom:25px; padding:20px; transition:0.3s; }
.order-card:hover { box-shadow:0 6px 18px rgba(0,0,0,0.15); }

/* Order Header */
.order-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; font-weight:bold; font-size:1rem; color:#4b0082; }

/* Payment Info */
.order-card > div:first-of-type { margin-bottom:15px; font-size:0.95rem; color:#555; }

/* Product Summary */
.product-summary { display:flex; gap:15px; border-top:1px solid #eee; padding:15px 0; align-items:center; }
.product-summary:first-of-type { border-top:none; padding-top:0; }

/* Product Image */
.product-summary img { width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ddd; }

/* Product Info */
.product-info h4 { font-size:1.05rem; margin-bottom:5px; color:#222; }
.product-info p { font-size:0.9rem; margin-bottom:3px; color:#555; }

/* Total Price */
.order-total { text-align:right; font-weight:bold; font-size:1.1rem; margin-top:15px; color:#4b0082; }

/* Responsive */
@media(max-width:768px){
    .product-summary { flex-direction: column; align-items:flex-start; }
    .product-summary img { width:100%; max-width:150px; }
    .order-header { flex-direction: column; align-items:flex-start; gap:5px; }
    .order-total { text-align:left; }
}
</style>
</head>
<body>
<div class="container">
    <h2>My Orders</h2>
    <?php foreach($orders as $orderId => $order): ?>
    <div class="order-card">
        <div class="order-header">
            <span>Order ID: <?= htmlspecialchars($orderId) ?></span>
            <span>Date: <?= htmlspecialchars($order['timestamp'] ?? 'N/A') ?></span>
        </div>
        <div>Payment Method: <b><?= htmlspecialchars($order['payment_method'] ?? 'N/A') ?></b></div>
        
        <?php 
        $orderTotal = 0;
        foreach($order['items'] as $item):
            $id = $item['id'];
            $qty = intval($item['quantity']);
            if(!isset($products[$id])) continue;
            $product = $products[$id];
            $unitPrice = floatval(preg_replace('/[^\d.]/','',$product['price']));
            $totalPrice = $unitPrice * $qty;
            $orderTotal += $totalPrice;
        ?>
        <div class="product-summary">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="product-info">
                <h4><?= htmlspecialchars($product['name']) ?></h4>
                <p>Qty: <?= $qty ?></p>
                <p>Unit Price: <?= $product['price'] ?></p>
                <p>Total: ₹<?= number_format($totalPrice,2) ?></p>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="order-total">Order Total: ₹<?= number_format($orderTotal,2) ?></div>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>
