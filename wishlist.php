<?php
session_start();

// Handle remove from wishlist
if (isset($_GET['remove_like'])) {
    $wid = $_GET['remove_like'];
    if (($key = array_search($wid, $_SESSION['wishlist'])) !== false) {
        unset($_SESSION['wishlist'][$key]);
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']); // Reindex
    }
    header("Location: wishlist.php");
    exit;
}

// Same products array as in index.php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Wishlist</title>
  <style>
    .product-grid { display: flex; flex-wrap: wrap; gap: 20px; }
    .product-card { border:1px solid #ddd; padding:10px; width:200px; }
  </style>
</head>
<body>
<h2>My Wishlist</h2>
<div class="product-grid">
  <?php if(empty($_SESSION['wishlist'])): ?>
    <p>Your wishlist is empty.</p>
  <?php else: ?>
    <?php foreach($_SESSION['wishlist'] as $wid): $p=$products[$wid]; ?>
      <div class="product-card">
        <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" width="150">
        <h3><?= $p['name'] ?></h3>
        <p><?= $p['price'] ?></p>
        <p><small><?= $p['company'] ?></small></p>
        <a href="wishlist.php?remove_like=<?= $wid ?>"><button>Remove</button></a>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
<a href="index.php">⬅ Back to Shop</a>
</body>
</html>
