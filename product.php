<?php
session_start();

// Example products with multiple images + specs
$products = [
    [
        "name"=>"Class M15",
        "price"=>"₹150",
        "images"=>[
            "images/thumbnail_EFL_Auto_Bin_Banner_1_6a2dec8338_1_346bd9dd2c.jpg",
            "images\AUTOBIN_01_8ccc13e150.jpg",
          
            "images/thumbnail_Home_Mapping_01_29b2581991.jpg",
           "images/Fully_auto_final_09_6c3a90c911.jpg",
           "images/Fully_auto_final_12_2e3e645876.jpg"
        ],
        "company"=>"Eureka Forbes",
        "info"=>"Compact and efficient vacuum cleaner for home use.",
        "specs" => [
            "short" => [
                "Dimension: 34.5 x 34.5 x 9.6 cm",
                "Suction: 5000 Pascal",
                "Run Time: up to 5 Hrs",
                "Dust Capacity: 330 ml",
                "Water Tank Capacity: 300 ml"
            ],
            "full" => [
                "Full Charge Time: ~5-6 hours",
                "Noise Level: <75 dB",
                "Wi-Fi Compatibility: 2.4 GHz",
                "Included Components: Robotic vacuum, charging dock, mop pad, extra brush, Hepa filter",
                "Gross Weight: 3.2 Kg"
            ]
        ]
    ],
    [
        "name"=>"Euroclean Glide",
        "price"=>"₹120",
        "images"=>[
           "images/thumbnail_Home_Mapping_01_29b2581991.jpg",
			"images/Fully_auto_final_19_e98061a1d5.jpg",
          "images/Fully_auto_final_18_878ce629f5.jpg",
          "images/Fully_auto_final_09_6c3a90c911.jpg"
        ],
        "company"=>"Eureka Forbes",
        "info"=>"Lightweight vacuum cleaner with powerful suction.",
        "specs" => [
            "short" => [
                "Dimension: 30 x 28 x 15 cm",
                "Suction: 4000 Pascal",
                "Run Time: up to 3 Hrs",
                "Dust Capacity: 280 ml",
                "Weight: 2.8 Kg"
            ],
            "full" => [
                "Full Charge Time: ~4 hours",
                "Noise Level: <70 dB",
                "Power Consumption: 100W",
                "Accessories: Extra brush, Hepa filter",
                "Warranty: 2 years"
            ]
        ]
    ],
    [
        "name"=>"Decker Vacuum",
        "price"=>"₹180",
        "images"=>[
           "images/AUTOBIN_01_8ccc13e150.jpg",
           "images/Fully_auto_final_19_e98061a1d5.jpg",
           "images/Fully_auto_final_18_878ce629f5.jpg",
            "images/Fully_auto_final_09_6c3a90c911.jpg",
            "images/Fully_auto_final_12_2e3e645876.jpg"
        ],
        "company"=>"Black & Decker",
        "info"=>"Durable and high-performance vacuum for heavy use.",
        "specs" => [
            "short" => [
                "Dimension: 38 x 32 x 18 cm",
                "Suction: 6000 Pascal",
                "Run Time: up to 4 Hrs",
                "Dust Capacity: 400 ml",
                "Weight: 3.5 Kg"
            ],
            "full" => [
                "Full Charge Time: 5 hours",
                "Noise Level: <72 dB",
                "Power Consumption: 120W",
                "Accessories: Hose, extra brush, Hepa filter",
                "Warranty: 3 years"
            ]
        ]
    ],
    [
        "name"=>"Karcher 2",
        "price"=>"₹200",
        "images"=>[
           "images/AUTOBIN_01_8ccc13e150.jpg",
            "images/Fully_auto_final_19_e98061a1d5.jpg",
           "images/Fully_auto_final_18_878ce629f5.jpg",
            "images/Fully_auto_final_12_2e3e645876.jpg"
        ],
        "company"=>"Karcher",
        "info"=>"German engineered vacuum with advanced cleaning system.",
        "specs" => [
            "short" => [
                "Dimension: 36 x 30 x 17 cm",
                "Suction: 5500 Pascal",
                "Run Time: 4.5 Hrs",
                "Dust Capacity: 350 ml",
                "Weight: 3.0 Kg"
            ],
            "full" => [
                "Full Charge Time: 4.5 hours",
                "Noise Level: <70 dB",
                "Water Tank Capacity: 250 ml",
                "Accessories: Mopping pad, brush, Hepa filter",
                "Warranty: 2 years"
            ]
        ]
    ],
    [
        "name"=>"Vacuum X",
        "price"=>"₹160",
        "images"=>[
           "images/AUTOBIN_01_8ccc13e150.jpg",
           "images/Fully_auto_final_19_e98061a1d5.jpg",
           "images/Fully_auto_final_18_878ce629f5.jpg",
           "imagesFully_auto_final_12_2e3e645876.jpg"
        ],
        "company"=>"Black & Decker",
        "info"=>"Stylish design with multiple cleaning modes.",
        "specs" => [
            "short" => [
                "Dimension: 32 x 28 x 16 cm",
                "Suction: 4800 Pascal",
                "Run Time: 3.5 Hrs",
                "Dust Capacity: 310 ml",
                "Weight: 2.9 Kg"
            ],
            "full" => [
                "Full Charge Time: 4 hours",
                "Noise Level: <68 dB",
                "Modes: Standard, Power, Eco",
                "Accessories: Side brush, cleaning tool",
                "Warranty: 2 years"
            ]
        ]
    ],
    [
        "name"=>"Cleaner Pro",
        "price"=>"₹140",
        "images"=>[
            "images/AUTOBIN_01_8ccc13e150.jpg",
            "images/Fully_auto_final_19_e98061a1d5.jpg",
           "images/Fully_auto_final_18_878ce629f5.jpg"
        ],
        "company"=>"Karcher",
        "info"=>"Portable vacuum cleaner with eco-friendly motor.",
        "specs" => [
            "short" => [
                "Dimension: 28 x 24 x 14 cm",
                "Suction: 4200 Pascal",
                "Run Time: 3 Hrs",
                "Dust Capacity: 270 ml",
                "Weight: 2.5 Kg"
            ],
            "full" => [
                "Full Charge Time: 3.5 hours",
                "Noise Level: <65 dB",
                "Eco Motor: Yes",
                "Accessories: Charging dock, extra mop",
                "Warranty: 1 year"
            ]
        ]
    ],
    [
        "name"=>"SuperVac 3000",
        "price"=>"₹250",
        "images"=>[
            "images/AUTOBIN_01_8ccc13e150.jpg",
            "images/Fully_auto_final_19_e98061a1d5.jpg",
            "images/Fully_auto_final_18_878ce629f5.jpg",
            "images/Fully_auto_final_12_2e3e645876.jpg"
        ],
        "company"=>"Eureka Forbes",
        "info"=>"Premium vacuum cleaner with auto dust bin technology.",
        "specs" => [
            "short" => [
                "Dimension: 40 x 35 x 20 cm",
                "Suction: 7000 Pascal",
                "Run Time: 6 Hrs",
                "Dust Capacity: 500 ml",
                "Weight: 4.2 Kg"
            ],
            "full" => [
                "Full Charge Time: 6 hours",
                "Noise Level: <74 dB",
                "Auto Dust Bin: Yes",
                "Accessories: Extra bin, Hepa filter",
                "Warranty: 3 years"
            ]
        ]
    ],
    [
        "name"=>"DustBuster Pro",
        "price"=>"₹300",
        "images"=>[
            "images/thumbnail_EFL_Auto_Bin_Banner_1_6a2dec8338_1_346bd9dd2c.jpg",
            "images/Fully_auto_final_18_878ce629f5.jpg",
           "images/Fully_auto_final_18_878ce629f5.jpg",
          "images/Fully_auto_final_12_2e3e645876.jpg"
        ],
        "company"=>"Black & Decker",
        "info"=>"Professional vacuum with extra dust holding capacity.",
        "specs" => [
            "short" => [
                "Dimension: 42 x 38 x 22 cm",
                "Suction: 7500 Pascal",
                "Run Time: 6.5 Hrs",
                "Dust Capacity: 600 ml",
                "Weight: 4.8 Kg"
            ],
            "full" => [
                "Full Charge Time: 6 hours",
                "Noise Level: <76 dB",
                "Accessories: Hose, bin, filter, cleaning brush",
                "Warranty: 3 years",
                "Coverage: 2000 sq.ft."
            ]
        ]
    ]
];


// Get product ID
$id = $_GET['id'] ?? null;
if($id === null || !isset($products[$id])){
    die("Product not found.");
}
$product = $products[$id];

// Add to cart
if(isset($_GET['add_to_cart'])){
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $exists = false;
    foreach($_SESSION['cart'] as &$cartItem){
        if($cartItem['name'] == $product['name']){
            $cartItem['quantity'] += 1;
            $exists = true;
            break;
        }
    }
    if(!$exists){
        $product['quantity'] = 1;
        $_SESSION['cart'][] = $product;
    }
    header("Location: cart.php");
    exit;
}

// Price calculations
$quantity = 1;
$unitPrice = floatval(preg_replace('/[^\d.]/', '', $product['price']));
$totalPrice = $unitPrice * $quantity;

// Similar products
$similar = [];
foreach($products as $pid => $p){
    if($pid != $id){
        $similar[] = $p;
    }
}

// Total items in cart
$totalItemsInCart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Detect if current page is cart
$isCartPage = basename($_SERVER['PHP_SELF']) == 'cart.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DROBOTIC</title>
<style>
/* Same CSS as before */
body { font-family: Arial,sans-serif; background:#f7f7f7; margin:0; padding-top:180px; }
a { text-decoration:none; color:inherit; }
header { background:#000; border-bottom:1px solid #ddd; position:fixed; top:0; left:0; width:100%; z-index:1000; }
header .container { width:95%; margin:auto; display:flex; justify-content:space-between; align-items:center; padding:15px 0; gap:20px; }
header .logo img { height:120px; border-radius:8px; }
nav ul { list-style:none; display:flex; gap:20px; align-items:center; }
nav ul li a { text-decoration:none; color:white; font-weight:bold; display:flex; align-items:center; gap:5px; font-size:1.2rem; }
nav ul li a:hover { color:yellow; }
nav ul li img { width:25px; height:25px; }
.cart-count { position:absolute; top:-8px; right:-12px; background:red; color:white; width:22px; height:22px; font-size:0.8rem; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; }
.main-container { display:flex; gap:30px; max-width:1000px; margin:30px auto; }
.product-container { flex:2; background:#fff; padding:20px; border-radius:8px; display:flex; gap:30px; }
.product-container img { width:350px; height:350px; object-fit:cover; border-radius:8px; }
.details { flex:1; }
.details h2 { margin-top:0; }
.price { color:green; font-size:1.5rem; margin:10px 0; font-weight:bold; }
.buttons { margin-top:20px; display:flex; gap:15px; }
button { padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-weight:bold; }
.add { background:#00aaff; color:#fff; }
.buy { background:purple; color:#fff; }
.add:hover { background:#0088cc; }
.buy:hover { background:darkviolet; }
.price-details { flex:1; background:#fff; padding:20px; border-radius:8px; height:max-content; }
.price-details h2 { margin-top:0; }
.price-summary { font-size:1.1rem; margin-top:20px; }
.price-summary div { display:flex; justify-content:space-between; margin:5px 0; }
.continue-btn { display:block; text-align:center; margin-top:20px; background:purple; color:#fff; padding:12px; border:none; border-radius:5px; font-size:1rem; text-decoration:none; }
.continue-btn:hover { background:darkviolet; }
.technical-specs { max-width:1000px; margin:40px auto; background:#fff; padding:20px; border-radius:8px; text-align:justify; }
.technical-specs h2 { font-size:1.5rem; margin-bottom:15px; }
.technical-specs ul { margin-top:10px; padding-left:20px; }
.technical-specs li { margin:5px 0; font-size:1rem; }
.technical-specs li strong { font-weight:bold; font-size:1.05rem; }
#specs-full { display:none; }
#show-more-btn { margin-top:10px; padding:10px; border:none; background:none; color:#00aaff; cursor:pointer; font-weight:bold; font-size:1rem; }
#show-more-btn:hover { text-decoration:underline; }
.gallery-container { display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:20px; }
.gallery-container img { width:100px; height:100px; object-fit:cover; border-radius:5px; cursor:pointer; border:2px solid transparent; }
.gallery-container img.active { border-color:#00aaff; }
.similar-container { max-width:1200px; margin:40px auto 0; }
.similar-container h3 { margin-bottom:20px; text-align:center; }
.similar-products { display:flex; gap:20px; flex-wrap:wrap; justify-content:center; }
.similar-card { background:#fff; border-radius:8px; padding:15px; width:200px; text-align:center; }
.similar-card img { width:150px; height:150px; object-fit:cover; border-radius:5px; }
.similar-card h4 { margin:10px 0 5px; font-size:1rem; }
.similar-card p { margin:5px 0; font-size:0.9rem; }
.similar-card .price { color:green; font-weight:bold; }
.similar-card form button { width:100%; margin-top:10px; background:#00aaff; color:#fff; }
.similar-card form button:hover { background:#0088cc; }



</style>
</head>
<body>

<!-- Header -->
<header>
  <div class="container">
    <div class="logo">
      <a href="index.php"><img src="images/WhatsApp Image 2025-09-10 at 11.42.02 AM.jpeg" alt="Logo"></a>
    </div>
    <nav>
      <ul>
        <li><a href="index.php"><img src="images/1499220364.png"  alt="Home"></a></li>
        <li class="cart-header">
          <a href="cart.php"><img src="images/1f6d2.svg" alt="Cart"></a>
          <?php if($totalItemsInCart > 0): ?>
            <span class="cart-count"><?= $totalItemsInCart ?></span>
          <?php endif; ?>
        </li>
      </ul>
    </nav>
  </div>
</header>

<!-- Main content -->
<div class="main-container">
    <div class="product-container">
        <img id="main-product-image" src="<?= htmlspecialchars($product['images'][0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="details">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><b>Brand:</b> <?= htmlspecialchars($product['company']) ?></p>
            <div class="price"><?= $product['price'] ?></div>
            <p><?= htmlspecialchars($product['info']) ?></p>

            <div class="buttons">
                <form method="get">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="add_to_cart" value="1">
                    <button type="submit" class="add">Add to Cart</button>
                </form>

                <form method="post" action="checkout.php">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit" class="buy">Buy Now</button>
                </form>
            </div>
        </div>

        <div class="price-details">
            <h2>Price Details (<?= $quantity ?> Item)</h2>
            <div class="price-summary">
                <div><span>Total Product Price</span><span><?= $product['price'] ?></span></div>
                <div><strong>Order Total</strong><strong><?= $product['price'] ?></strong></div>
            </div>
            <a href="payment.php" class="continue-btn">Continue</a>
        </div>
    </div>
</div>

<div class="gallery-container">
    <?php foreach ($product['images'] as $index => $img): ?>
        <img 
            src="<?= htmlspecialchars($img) ?>" 
            onclick="changeMainImage(this)" 
            class="<?= $index == 0 ? 'active' : '' ?>"
        >
    <?php endforeach; ?>
</div>


</div>

<script>
function changeImage(element) {
    document.getElementById('mainProductImg').src = element.src;
}
</script>
<script>
function changeMainImage(el){
    document.getElementById("main-product-image").src = el.src;

    // Highlight active thumbnail
    document.querySelectorAll(".gallery-container img")
    .forEach(img => img.classList.remove("active"));
    el.classList.add("active");
}
</script>


<!-- Technical Specifications -->
<div class="technical-specs">
    <h2>Technical Information</h2>
    <ul id="specs-short">
        <?php foreach($product['specs']['short'] as $s): ?>
            <li><?= htmlspecialchars($s) ?></li>
        <?php endforeach; ?>
    </ul>
    <ul id="specs-full">
        <?php foreach($product['specs']['full'] as $s): ?>
            <li><?= htmlspecialchars($s) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php if(!$isCartPage): ?>
        <button id="show-more-btn" onclick="toggleMore()">Show More Details</button>
    <?php endif; ?>
</div>

<!-- Similar Products -->
<?php if(!empty($similar)): ?>
<div class="similar-container">
    <h3>Similar Products</h3>
    <div class="similar-products">
        <?php foreach($similar as $sp): ?>
        <div class="similar-card">
            <img src="<?= htmlspecialchars($sp['images'][0]) ?>" alt="<?= htmlspecialchars($sp['name']) ?>">
            <h4><?= htmlspecialchars($sp['name']) ?></h4>
            <p><b>Brand:</b> <?= htmlspecialchars($sp['company']) ?></p>
            <div class="price"><?= $sp['price'] ?></div>
            <form method="get">
                <input type="hidden" name="id" value="<?= array_search($sp, $products) ?>">
                <button type="submit">View</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>
function changeMainImage(el){
    document.getElementById("main-product-image").src = el.src;
    document.querySelectorAll(".gallery-container img").forEach(img=>img.classList.remove("active"));
    el.classList.add("active");
}
function toggleMore(){
    const full = document.getElementById("specs-full");
    const btn = document.getElementById("show-more-btn");
    if(full.style.display === "none" || full.style.display === ""){
        full.style.display = "block";
        btn.textContent = "Show Less Details";
    } else {
        full.style.display = "none";
        btn.textContent = "Show More Details";
    }
}
</script>
</body>
</html>
