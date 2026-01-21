<?php
session_start();

// Check if user is logged in
function is_logged_in(){
    return isset($_SESSION['user_id']); // Use your login session key
}

// Initialize cart if not set
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Handle Add-to-Cart
if(isset($_GET['add'])){
    $product = [
        "name" => $_GET['name'] ?? "Unknown",
        "company" => $_GET['company'] ?? "",
        "price" => $_GET['price'] ?? "0",
        "quantity" => 1,
        "images" => [$_GET['image'] ?? "images/no-image.png"],
        "info" => $_GET['info'] ?? ""
    ];

    // If product already exists in cart, increase quantity
    $found = false;
    foreach($_SESSION['cart'] as &$item){
        if($item['name'] === $product['name']){
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    if(!$found){
        $_SESSION['cart'][] = $product;
    }
    header("Location: cart.php");
    exit;
}

// Remove item if requested
if(isset($_GET['remove'])){
    $index = $_GET['remove'];
    if(isset($_SESSION['cart'][$index])){
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex
    }
    header("Location: cart.php");
    exit;
}

// Update quantity
if(isset($_GET['update'])){
    $index = $_GET['update'];
    $quantity = intval($_GET['quantity']);
    if(isset($_SESSION['cart'][$index]) && $quantity > 0){
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
    header("Location: cart.php");
    exit;
}

// Calculate totals
$totalPrice = 0;
$totalItems = 0;
foreach($_SESSION['cart'] as $item){
    $price = floatval(preg_replace('/[^\d.]/', '', $item['price']));
    $totalPrice += $price * $item['quantity'];
    $totalItems += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DROBOTIC</title>
<style>
body { font-family: Arial,sans-serif; margin:0; padding-top:180px; background:#f7f7f7; }

/* Header & Cart Styles */
header { background:#000; border-bottom:1px solid #ddd; position:fixed; top:0; left:0; width:100%; z-index:1000; }
header .container { width:95%; margin:auto; display:flex; justify-content:space-between; align-items:center; padding:15px 0; gap:20px; }
header .logo img { height:120px; border-radius:8px; }
nav ul { list-style:none; display:flex; gap:20px; align-items:center; }
nav ul li a { text-decoration:none; color:white; font-weight:bold; display:flex; align-items:center; gap:5px; font-size:1.2rem; }
nav ul li a:hover { color:yellow; }
nav ul li img { width:25px; height:25px; }
.cart-count { position:absolute; top:-8px; right:-12px; background:red; color:white; width:22px; height:22px; font-size:0.8rem; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; }

/* Cart Styles */
.cart-container { max-width:1000px; margin:20px auto; background:#fff; padding:20px; border-radius:8px; display:flex; gap:20px; }
.cart-items { flex:2; }
.cart-item { display:flex; gap:20px; padding:15px 0; border-bottom:1px solid #ddd; align-items:flex-start; }
.cart-item img { width:100px; height:100px; object-fit:cover; border-radius:5px; }
.cart-item-details { flex:2; }
.cart-item-details strong { font-size:1.1rem; }
.cart-item-details small { color:#666; }
.cart-item-info { font-size:0.9rem; color:#333; margin-top:5px; }
.cart-item-actions { font-size:0.9rem; color:#555; margin-top:8px; }
.cart-item-actions a { margin-right:15px; color:#00aaff; text-decoration:none; }
.cart-item-actions a:hover { text-decoration:underline; }
.cart-item-price, .cart-item-quantity, .cart-item-total { flex:1; text-align:center; font-weight:bold; }
.cart-item-total { color:green; }
select { padding:5px; }
button { padding:10px 20px; background:#00aaff; border:none; color:white; border-radius:5px; cursor:pointer; }
button:hover { background:#0088cc; }

/* ✅ Price Details Styles */
.price-details {
    flex:1;
    padding:20px;
    border-radius:12px;
    background:#fff;
    box-shadow:0px 2px 8px rgba(0,0,0,0.1);
    height:fit-content;
}
.price-details h2 {
    margin:0 0 15px;
    font-size:1.2rem;
    font-weight:bold;
}
.price-summary div {
    display:flex;
    justify-content:space-between;
    margin:8px 0;
    font-size:1rem;
}
.price-summary div strong {
    font-weight:bold;
}
.continue-btn {
    width:100%;
    margin-top:15px;
    padding:12px;
    font-size:1rem;
    border:none;
    border-radius:6px;
    background:purple;
    color:#fff;
    cursor:pointer;
    font-weight:bold;
}
.continue-btn:hover { background:#800080; }

/* Responsive */
@media(max-width:900px){ 
    header .container { flex-direction:column; align-items:flex-start; padding:10px; }
    body { padding-top:220px; }
    .cart-container { flex-direction:column; }
    .cart-item { flex-direction:column; align-items:flex-start; }
    .cart-item-price, .cart-item-quantity, .cart-item-total { text-align:left; }
}
</style>
</head>
<body>

<header>
  <div class="container">
    <div class="logo">
      <a href="index.php"><img src="images/WhatsApp Image 2025-09-10 at 11.42.02 AM.jpeg" alt="Logo"></a>
    </div>
    <nav>
      <ul>
        <li><a href="index.php"><img src="images/1499220364.png" alt="Home"></a></li>
        <li class="cart-header">
          <a href="cart.php"><img src="images/1f6d2.svg" alt="Cart"></a>
          <?php if($totalItems > 0): ?>
            <span class="cart-count"><?= $totalItems ?></span>
          <?php endif; ?>
        </li>
        <li><a href="wishlist.php"><img src="images/2764.svg" alt="wishlist"></a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="cart-container">
    <div class="cart-items">
        <h2>My Cart</h2>
        <?php if(empty($_SESSION['cart'])): ?>
            <p>Your cart is empty. <a href="index.php">Go back to shop</a></p>
        <?php else: ?>
            <?php foreach($_SESSION['cart'] as $index => $item): 
                $price = floatval(preg_replace('/[^\d.]/', '', $item['price']));
                $subtotal = $price * $item['quantity'];
                $imagePath = !empty($item['images'][0]) ? $item['images'][0] : 'images/no-image.png';
            ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="cart-item-details">
                    <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                    <small><?= htmlspecialchars($item['company']) ?></small>
                    <?php if(!empty($item['info'])): ?>
                        <div class="cart-item-info">ℹ️ <?= htmlspecialchars($item['info']) ?></div>
                    <?php endif; ?>
                    <div class="cart-item-actions">
                        <a href="?remove=<?= $index ?>"> ❌ Remove</a>
                    </div>
                </div>
                <div class="cart-item-price">₹<?= $price ?> each</div>
                <div class="cart-item-quantity">
                    <form method="get" style="display:inline;">
                        <input type="hidden" name="update" value="<?= $index ?>">
                        <select name="quantity" onchange="this.form.submit()">
                            <?php for($i=1;$i<=10;$i++): ?>
                                <option value="<?= $i ?>" <?= $i==$item['quantity']?'selected':'' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </div>
                <div class="cart-item-total">Subtotal: ₹<?= $subtotal ?></div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ✅ Price Details Section -->
    <?php if($totalItems > 0): ?>
    <div class="price-details">
        <h2>Price Details (<?= $totalItems ?> <?= $totalItems > 1 ? 'Items' : 'Item' ?>)</h2>
        <div class="price-summary">
            <div><span>Total Product Price</span><span>₹<?= $totalPrice ?></span></div>
            <div><strong>Order Total</strong><strong>₹<?= $totalPrice ?></strong></div>
        </div>
        <form action="address.php" method="post">
            <input type="hidden" name="total_items" value="<?= $totalItems ?>">
            <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
            <button type="submit" class="continue-btn">Continue</button>
        </form>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
