<?php
session_start();

// Example products
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

// ✅ Load cart from session only
$cart = $_SESSION['cart'] ?? [];
if(empty($cart)){
    die("Your cart is empty. Please add products first.");
}

// Calculate totals
$totalAmount = 0;
$validCartItems = [];
foreach($cart as $item){
    if(!isset($item['id'])) continue;
    $id = intval($item['id']);
    $quantity = intval($item['quantity'] ?? 1);
    if(isset($products[$id])){
        $unitPrice = (float) preg_replace('/[^\d.]/','',$products[$id]['price']); 
        $totalAmount += $unitPrice * $quantity;

        $validCartItems[] = [
            'id'=>$id,
            'quantity'=>$quantity,
            'unitPrice'=>$unitPrice
        ];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>DROBOTIC</title>
<style>
body { font-family: Arial, sans-serif; margin:0; background:#f7f7f7; padding:20px; }
.container { max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:8px; text-align:center; }
.product-summary { display:flex; gap:15px; border-bottom:1px solid #ddd; padding-bottom:15px; margin-bottom:15px; text-align:left; }
.product-summary img { width:100px; height:100px; object-fit:cover; border-radius:5px; }
.product-info h3 { margin:0; font-size:1.1rem; }
.payment-methods button { padding:12px; background:purple; border:none; color:#fff; border-radius:5px; cursor:pointer; margin:5px; }
</style>
</head>
<body>
<div class="container">
    <h2>Payment Options</h2>

    <!-- Products -->
    <?php foreach($validCartItems as $item): 
        $id = $item['id']; 
        $quantity = $item['quantity'];
        $product = $products[$id];
        $unitPrice = $item['unitPrice'];
        $totalPrice = $unitPrice * $quantity;
    ?>
    <div class="product-summary">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="product-info">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p>Qty: <?= $quantity ?></p>
            <p>Unit Price: ₹<?= number_format($unitPrice,2) ?></p>
            <p><b>Total: ₹<?= number_format($totalPrice,2) ?></b></p>
        </div>
    </div>
    <?php endforeach; ?>

    <h3>Total Amount: ₹<?= number_format($totalAmount,2) ?></h3>

    <!-- Payment Form -->
    <form method="post" action="confirmation.php">
        <div class="payment-methods">
            <a href="credit_card.php"><button type="button">Pay with Credit Card</button></a>
            <a href="upi_payment.php"><button type="button">Pay with UPI</button></a>
        </div>
    </form>
</div>
</body>
</html>
