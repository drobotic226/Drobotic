<?php
session_start();

/* -------------------------------
   PRODUCTS LIST
-------------------------------- */
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

/* -------------------------------
   CART CHECK
-------------------------------- */
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    die("Your cart is empty. Please add products first.");
}

/* -------------------------------
   TOTAL CALCULATION
-------------------------------- */
$totalAmount = 0;
$orderItems = [];

foreach ($cart as $item) {
    $id = $item['id'] ?? null;
    $qty = intval($item['quantity'] ?? 0);

    if ($id !== null && isset($products[$id])) {
        $price = floatval(preg_replace('/[^\d.]/', '', $products[$id]['price']));
        $subtotal = $price * $qty;

        $orderItems[] = [
            'name' => $products[$id]['name'],
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $subtotal
        ];

        $totalAmount += $subtotal;
    }
}

/* -------------------------------
   PAYMENT SUBMIT
-------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $card_number = trim($_POST['card_number'] ?? '');
    $card_name   = trim($_POST['card_name'] ?? '');
    $expiry      = trim($_POST['expiry'] ?? '');
    $cvv         = trim($_POST['cvv'] ?? '');

    if ($card_number && $card_name && $expiry && $cvv) {

        // Generate order ID
        $orderId = "ORD-" . date("Ymd") . "-" . rand(100000, 999999);

        // Save order
        $_SESSION['orders'][$orderId] = [
            'items' => $orderItems,
            'total' => $totalAmount,
            'payment_method' => "Credit Card",
            'address' => $_SESSION['selected_address'] ?? null,
            'timestamp' => date("Y-m-d H:i:s")
        ];

        // Clear cart
        unset($_SESSION['cart']);

        header("Location: confirmation.php?order_id=" . $orderId);
        exit;

    } else {
        $error = "Please fill all card details.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>DROBOTIC - Payment</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body { font-family: Arial, sans-serif; margin:0; background:#f7f7f7; padding:20px; }
.container { max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px; }
h2,h3 { margin-bottom:10px; }
table { width:100%; border-collapse: collapse; margin-bottom:15px; }
th,td { border:1px solid #ccc; padding:8px; }
th { background:#f0f0f0; }
input { width:100%; padding:10px; margin:8px 0; }
button { padding:12px; background:green; border:none; color:#fff; cursor:pointer; border-radius:5px; width:100%; }
.error { color:red; }
</style>
</head>

<body>
<div class="container">

<h2>Pay with Credit Card</h2>

<!-- ORDER SUMMARY -->
<h3>Order Summary</h3>
<table>
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Subtotal</th>
    </tr>

    <?php foreach ($orderItems as $item): ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td align="center"><?= $item['qty'] ?></td>
        <td align="right">₹<?= number_format($item['price'], 2) ?></td>
        <td align="right">₹<?= number_format($item['subtotal'], 2) ?></td>
    </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="3" align="right"><b>Total</b></td>
        <td align="right"><b>₹<?= number_format($totalAmount, 2) ?></b></td>
    </tr>
</table>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<!-- PAYMENT FORM -->
<form method="post">
    <input type="text" name="card_number" placeholder="Card Number" required>
    <input type="text" name="card_name" placeholder="Name on Card" required>
    <input type="text" name="expiry" placeholder="MM/YY" required>
    <input type="password" name="cvv" placeholder="CVV" required>
    <button type="submit">Confirm & Pay</button>
</form>

</div>
</body>
</html>
