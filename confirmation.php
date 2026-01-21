<?php
session_start();

// Example products same as payment.php
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

// Get cart
$cart = $_SESSION['cart'] ?? [];
if(empty($cart)){
    die("Cart is empty. Cannot confirm order.");
}

// Payment method from previous page
$paymentMethod = $_POST['pay_method'] ?? 'Unknown';

// Calculate totals
$totalAmount = 0;
$validCartItems = [];
foreach($cart as $item){
    $id = $item['id'];
    $quantity = intval($item['quantity']);
    if(isset($products[$id])){
        $validCartItems[] = ['id'=>$id,'quantity'=>$quantity];
        $unitPrice = floatval(preg_replace('/[^\d.]/','',$products[$id]['price']));
        $totalAmount += $unitPrice * $quantity;
    }
}

// Store order in session for My Orders
if(!isset($_SESSION['orders'])) $_SESSION['orders'] = [];
$orderId = uniqid('ORD');
$_SESSION['orders'][$orderId] = [
    'items' => $validCartItems,
    'payment_method' => $paymentMethod,
    'total_amount' => $totalAmount,
    'timestamp' => date("Y-m-d H:i:s")
];

// Optional: Clear cart after confirmation
$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html>
<head>
<title>DROBOTIC</title>
<style>
body { font-family: Arial, sans-serif; margin:0; background:#f7f7f7; padding:20px; }
.container { max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:8px; text-align:center; }
</style>
</head>
<body>
<div class="container">
    <h2>Order Confirmation</h2>

    <!-- Order Confirmed Image -->
    <div>
        <img src="images/images (1).png" alt="Order Confirmed" style="max-width:250px;">
    </div>
</div>
</body>
</html>
