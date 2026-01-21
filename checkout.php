<?php
session_start();

// Example products
$products = [
    ["name"=>"Class M15","price"=>"₹150","image"=>"images/312489_nz9ucg.png","company"=>"Eureka Forbes","info"=>"Compact and efficient vacuum cleaner for home use."], 
    ["name"=>"Euroclean Glide","price"=>"₹120","image"=>"images/312756_h1yc9m.png","company"=>"Eureka Forbes","info"=>"Lightweight vacuum cleaner with powerful suction."],
    ["name"=>"Decker Vacuum","price"=>"₹180","image"=>"images/312488_bvgyqz.png","company"=>"Black & Decker","info"=>"Durable and high-performance vacuum for heavy use."],
    ["name"=>"Karcher 2","price"=>"₹200","image"=>"images/312489_nz9ucg.png","company"=>"Karcher","info"=>"German engineered vacuum with advanced cleaning system."],
    ["name"=>"Vacuum X","price"=>"₹160","image"=>"images/312756_h1yc9m.png","company"=>"Black & Decker","info"=>"Stylish design with multiple cleaning modes."],
    ["name"=>"Cleaner Pro","price"=>"₹140","image"=>"images/312756_h1yc9m.png","company"=>"Karcher","info"=>"Portable vacuum cleaner with eco-friendly motor."],
    ["name"=>"SuperVac 3000","price"=>"₹250","image"=>"images/thumbnail_AUTOBIN_01_dc5df37216.jpg","company"=>"Eureka Forbes","info"=>"Premium vacuum cleaner with auto dust bin technology."],
    ["name"=>"DustBuster Pro","price"=>"₹300","image"=>"images/thumbnail_EFL_Auto_Bin_Banner_1_6a2dec8338_1_346bd9dd2c.jpg","company"=>"Black & Decker","info"=>"Professional vacuum with extra dust holding capacity."],
];

$id = $_POST['id'] ?? null;
if($id === null || !isset($products[$id])){
    die("Product not found.");
}

$product = $products[$id];
$unitPrice = floatval(preg_replace('/[^\d.]/', '', $product['price']));
$quantity = 1;
$totalPrice = $unitPrice * $quantity;
$totalItemsInCart = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DROBOTIC</title>
<style>
body { font-family: Arial, sans-serif; margin:0; background:#f7f7f7; padding:20px; }
header { background:#000; border-bottom:1px solid #ddd; position:fixed; top:0; left:0; width:100%; z-index:1000; }
header .container { width:95%; margin:auto; display:flex; justify-content:space-between; align-items:center; padding:15px 0; gap:20px; }
header .logo img { height:120px; border-radius:8px; }
nav ul { list-style:none; display:flex; gap:20px; align-items:center; }
nav ul li a { text-decoration:none; color:white; font-weight:bold; display:flex; align-items:center; gap:5px; font-size:1.2rem; }
nav ul li a:hover { color:yellow; }
nav ul li img { width:25px; height:25px; }
.cart-count { position:absolute; top:-8px; right:-12px; background:red; color:white; width:22px; height:22px; font-size:0.8rem; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; }
.checkout-container { max-width:1000px; margin:180px auto 0; display:flex; gap:30px; }
.product-details, .price-details { background:#fff; padding:20px; border-radius:8px; flex:1; }
.product { display:flex; gap:15px; border-bottom:1px solid #ddd; padding-bottom:15px; margin-bottom:15px; }
.product img { width:100px; height:100px; object-fit:cover; border-radius:5px; }
.product-info { flex:1; }
.product-info h3 { margin:0; font-size:1.1rem; }
.price-summary { font-size:1.1rem; margin-top:20px; display:flex; flex-direction:column; gap:10px; }
.continue-btn { display:block; text-align:center; margin-top:20px; background:purple; color:#fff; padding:12px; border:none; border-radius:5px; font-size:1rem; cursor:pointer; text-decoration:none; }
.continue-btn:hover { background:darkviolet; }
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
        <li><a href="index.php"><img src="images/1499220364.png"  alt="Home"></a></li>
        <li class="cart-header">
          <a href="cart.php"><img src="images/download.png" alt="Cart"></a>
          <?php if($totalItemsInCart > 0): ?>
            <span class="cart-count"><?= $totalItemsInCart ?></span>
          <?php endif; ?>
        </li>
        <li><a href="login.php"><img src="images/download (1).jfif" alt="Login"></a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="checkout-container">
    <div class="product-details">
        <h2>Product Details</h2>
        <div class="product">
            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
            <div class="product-info">
                <h3><?= $product['name'] ?></h3>
                <!-- ✅ show original product price -->
                <p>Price: <?= $product['price'] ?></p>
                <p>Qty: <?= $quantity ?></p>
            </div>
        </div>
        <p><b>Sold by:</b> <?= $product['company'] ?> | Free Delivery</p>
    </div>

    <div class="price-details">
        <h2>Price Details (<?= $quantity ?> Item)</h2>
        <div class="price-summary">
            <!-- ✅ show original product price -->
            <div><span>Total Product Price</span><span><?= $product['price'] ?></span></div>
            <div><strong>Order Total</strong><strong><?= $product['price'] ?></strong></div>
        </div>
        <form action="address.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="quantity" value="<?= $quantity ?>">
            <button type="submit" class="continue-btn">Continue</button>
        </form>
    </div>
</div>

</body>
</html>
