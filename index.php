<?php
session_start(); // Start session for cart

// Initialize cart if not set
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Flash message
$flashMessage = '';
if(isset($_SESSION['flash_message'])){
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// Example product data
$products = [
    ["name"=>"Class M15","price"=>"₹150","image"=>"images/312489_nz9ucg.png","company"=>"Eureka Forbes"], 
    ["name"=>"Euroclean Glide","price"=>"₹120","image"=>"images/312756_h1yc9m.png","company"=>"Eureka Forbes"],
    ["name"=>"Decker Vacuum","price"=>"₹180","image"=>"images/312488_bvgyqz.png","company"=>"Black & Decker"],
    ["name"=>"Karcher 2","price"=>"₹200","image"=>"images/312489_nz9ucg.png","company"=>"Karcher"],
    ["name"=>"Vacuum X","price"=>"₹160","image"=>"images/312756_h1yc9m.png","company"=>"Black & Decker"],
    ["name"=>"Cleaner Pro","price"=>"₹140","image"=>"images/312756_h1yc9m.png","company"=>"Karcher"],
    ["name"=>"SuperVac 3000","price"=>"₹250","image"=>"images/thumbnail_AUTOBIN_01_dc5df37216.jpg","company"=>"Eureka Forbes"],
    ["name"=>"DustBuster Pro","price"=>"300","image"=>"images/thumbnail_EFL_Auto_Bin_Banner_1_6a2dec8338_1_346bd9dd2c.jpg","company"=>"Black & Decker"],
];

// Clear cart
if(isset($_GET['clear_cart'])){
    $_SESSION['cart'] = [];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Get selected company
$selectedCompany = $_GET['company'] ?? 'All';

// Get selected price sort
$priceSort = $_GET['sort'] ?? 'default';

// Filter products by company
$filteredProducts = [];
if($selectedCompany == 'All'){
    $filteredProducts = $products;
} else {
    foreach($products as $p){
        if($p['company'] == $selectedCompany){
            $filteredProducts[] = $p;
        }
    }
}

// Sort products by price
if($priceSort == 'low-high'){
    usort($filteredProducts, function($a, $b){
        $priceA = floatval(preg_replace('/[^0-9.]/', '', $a['price']));
        $priceB = floatval(preg_replace('/[^0-9.]/', '', $b['price']));
        return $priceA <=> $priceB;
    });
} elseif($priceSort == 'high-low'){
    usort($filteredProducts, function($a, $b){
        $priceA = floatval(preg_replace('/[^0-9.]/', '', $a['price']));
        $priceB = floatval(preg_replace('/[^0-9.]/', '', $b['price']));
        return $priceB <=> $priceA;
    });
}

// Handle AJAX for AI search suggestions
if(isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    $q = strtolower($_GET['q'] ?? '');
    $suggestions = [];
    if($q != '') {
        foreach($products as $p) {
            if(strpos(strtolower($p['name']), $q) !== false) {
                $suggestions[] = $p['name'];
            }
        }
    }
    echo json_encode($suggestions);
    exit;
}

// Companies & Logos
$companyLogos = [ 
    "Eureka Forbes" => "images/eureka.jpg",
    "Black & Decker" => "images/Black+Decker_Logo.svg.png",
    "Karcher" => "images/Kaercher_Logo_2015.png"
];

// Total items in cart
$totalItemsInCart = 0;
foreach($_SESSION['cart'] as $c){
    $totalItemsInCart += $c['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DROBOTIC</title>
<link rel="icon" href="images/logo.png" type="image/png">
<link rel="shortcut icon" href="images\WhatsApp Image 2025-09-10 at 11.42.02 AM.jpeg" type="image/png">
<style>
body { font-family: Arial,sans-serif; line-height:1.6; padding-top:200px; }
* { margin:0; padding:0; box-sizing:border-box; }

/* Header */
header { background:#000; border-bottom:1px solid #ddd; position:fixed; top:0; left:0; width:100%; z-index:1000; }
header .container { width:95%; margin:auto; display:flex; justify-content:space-between; align-items:center; padding:15px 0; gap:20px; }
.logo img { height:150px; border-radius:8px; }
nav ul { list-style:none; display:flex; gap:20px; align-items:center; }

/* Updated header links to remove white background */
nav ul li a {
  text-decoration:none;
  color:white;
  font-weight:bold;
  display:flex;
  align-items:center;
  gap:5px;
  font-size:1.3rem;
  background: none;
  padding: 0;
  border-radius: 0;
}
nav ul li a img {
  width:25px;
  height:25px;
  background: none;
}

/* Cart count */
.cart-count { position:absolute; top:-8px; right:-12px; background:red; color:white; width:22px; height:22px; font-size:0.8rem; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; }

/* Search box */
.search-box { flex:1; display:flex; justify-content:center; position:relative; }
.search-box form {
  display:flex;
  align-items:center;
  width:100%;
  max-width:600px;
  background:#fff;
  border:1px solid #ccc;
  border-radius:30px;
  padding:8px 12px;
}
.search-box input {
  flex:1;
  border:none;
  outline:none;
  font-size:1rem;
  padding:8px;
}
.search-icon {
  font-size:1.2rem;
  margin-right:8px;
  color:#888;
}
.icon-btn {
  background:none;
  border:none;
  cursor:pointer;
  font-size:1.2rem;
  margin-left:8px;
  color:#555;
}
.icon-btn:hover { color:#0088cc; }

/* AI Suggestions */
.suggestions-box { position:absolute; background:white; border:1px solid #ddd; width:100%; z-index:100; border-radius:5px; margin-top:5px; display:none; max-height:200px; overflow-y:auto; }
.suggestions-box div { padding:10px; cursor:pointer; }
.suggestions-box div:hover { background:#f0f0f0; }

/* Features */
.features { display:flex; justify-content:space-between; margin:50px auto; gap:20px; width:90%; flex-wrap:wrap; }
.feature { width:30%; background:#fafafa; padding:20px; border-radius:10px; text-align:center; border:1px solid #eee; }
.feature h3 { margin-bottom:15px; color:#333; }
.feature p { font-size:0.95rem; color:#555; }

/* Image */
.products-image img { width:100%; height:500px; object-fit:cover; border-radius:10px; margin:30px auto; display:block; }

/* Company Filter (Logos) */
.company-filter { text-align:center; margin:30px auto; }
.company-logos { display:flex; justify-content:center; gap:20px; flex-wrap:wrap; }
.company-logo img { width:200px; height:120px; object-fit:contain; cursor:pointer; transition:transform 0.2s, border 0.2s; border:2px solid transparent; border-radius:8px; background:#fff; padding:10px; }
.company-logo:hover img { transform:scale(1.05); border-color:#aaa; }
.company-logo.active img { border-color:purple; transform:scale(1.1); }

/* Price Filter */
.price-filter { text-align:center; margin:20px 0; }
.price-filter select { padding:6px 12px; border-radius:8px; border:1px solid #ccc; font-size:1rem; }

/* Products */
.products { margin:50px auto; width:90%; }
.products h2 { text-align:center; margin-bottom:20px; }
.product-grid { display:grid; grid-template-columns: repeat(4, 1fr); gap:20px; }
.product-card { border:1px solid #ddd; border-radius:10px; padding:15px; text-align:center; transition:0.3s; background:#fff; }
.product-card:hover { box-shadow:0 0 10px rgba(0,0,0,0.2); }
.product-card img { width:100%; height:150px; object-fit:cover; border-radius:5px; margin-bottom:10px; cursor:pointer; }
.product-card h3 { font-size:1.1rem; margin-bottom:5px; }
.product-card .price { font-weight:bold; color:#00aaff; margin-bottom:10px; }
.product-card button { padding:8px 15px; background:#00aaff; border:none; color:#fff; border-radius:5px; cursor:pointer; }
.product-card button:hover { background:#0088cc; }



.product-card img {
    width: 100%;
    height: 120px;       /* decrease size from 150px → 120px */
    object-fit: contain; /* show full image without cropping */
    background: #fff;    /* optional: gives clean white background */
    border-radius: 5px;
    margin-bottom: 10px;
    cursor: pointer;
    padding: 5px;        /* optional: gives spacing around image */
}



/* Video Section */
.video-section { text-align:center; margin:50px auto; width:90%; }
.video-section h2 { margin-bottom:20px; }
.video-container { position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:10px; }
.video-container iframe, .video-container video { position:absolute; top:0; left:0; width:100%; height:100%; }

/* Footer */
footer { background:#333; color:white; text-align:center; padding:15px; margin-top:50px; }

/* WhatsApp Button */
.whatsapp-btn { position:fixed; bottom:20px; right:20px; background:#25D366; border-radius:50%; width:60px; height:60px; display:flex; justify-content:center; align-items:center; box-shadow:0 4px 6px rgba(0,0,0,0.2); cursor:pointer; text-decoration:none; z-index:1000; }
.whatsapp-btn:hover { background:#1ebe57; }
.whatsapp-btn img { width:40px; height:40px; }

@media(max-width:900px){ 
  header .container { flex-direction:column; } 
  .search-box { width:100%; margin:15px 0; } 
  nav ul { flex-wrap:wrap; justify-content:center; } 
  .search-box form { width:90%; } 
  .features .feature { width:100%; margin-bottom:20px; } 
  .product-grid { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width:600px){ .product-grid { grid-template-columns: 1fr; } }

/* Flash message */
.flash-msg {
    position: fixed; top:120px; left:50%; transform:translateX(-50%);
    background:#ffdd57; color:#000; padding:12px 20px; border-radius:8px;
    font-weight:bold; z-index:2000; display:none;
}
.flash-msg a {
    margin-left:15px;
    background:#000; color:#fff; padding:5px 10px; border-radius:5px;
    text-decoration:none;
}
.flash-msg a:hover { background:purple; }

/* Mobile Screen Size */
@media(max-width:480px){
  body { padding-top:120px; font-size:14px; }
  header .container { flex-direction:column; align-items:center; gap:10px; }
  .logo img { height:100px; }
  .search-box form { width:100%; padding:6px 10px; border-radius:20px; }
  .search-box input { font-size:0.9rem; padding:6px; }
  nav ul { gap:10px; flex-wrap:wrap; justify-content:center; }
  nav ul li a img { width:20px; height:20px; }
  .product-grid { grid-template-columns: 1fr; gap:15px; }
  .product-card img { height:120px; }
  .features { flex-direction:column; width:95%; }
  .feature { width:100%; margin-bottom:15px; }
  .company-logo img { width:120px; height:80px; }
  footer { font-size:0.9rem; padding:10px; }
  .whatsapp-btn, a[href^="tel:"] { width:50px; height:50px; }
  .whatsapp-btn img, a[href^="tel:"] img { width:28px; height:28px; }
}
</style>
</head>
<body>
<!-- rest of your HTML/PHP remains unchanged -->


<header>
  <div class="container">
    <div class="logo">
      <img src="images/WhatsApp Image 2025-09-10 at 11.42.02 AM.jpeg" alt="Logo">
    </div>
    <!-- Search Box -->
    <div class="search-box">
      <form action="" method="get" id="search-form" enctype="multipart/form-data">
        <span class="search-icon">🔍</span>
        <input type="text" name="q" id="search-input" placeholder="Search by Keyword or Product ID" autocomplete="off">
        <button type="button" id="voice-btn" class="icon-btn" title="Search by Voice">🎤</button>
        <label for="camera-input" class="icon-btn" title="Search by Image">📷</label>
        <input type="file" accept="image/*" capture="environment" id="camera-input" name="image" style="display:none">
        <div id="suggestions" class="suggestions-box"></div>
      </form>
    </div>
    <nav>
  <ul>
    <li><a href="index.php"><img src="images/1499220364.png" alt="Home"></a></li>
    <li class="cart-header">
      <a href="cart.php"><img src="images/1f6d2.svg" alt="Cart"></a>
      <?php if($totalItemsInCart > 0): ?>
        <span class="cart-count"><?= $totalItemsInCart ?></span>
      <?php endif; ?>
    </li>
    <li><a href="my_order.php"><img src="images/9422789.png" alt="My Orders" title="My Orders"></a></li> <!-- Added My Orders -->
    <li><a href="login.php"><img src="images/0766d183119ff92920403eb7ae566a85.jpg" alt="Login"></a></li>
    <li><a href="wishlist.php"><img src="images/2764.svg" alt="Wishlist"></a></li>
  </ul>
</nav>

  </div>
</header>

<!-- Features -->
<section class="features">
  <div class="feature">
    <h3>Easy Maneuvering</h3>
    <p>In vacuum cleaners, the pivoting ball makes steering simple.</p>
  </div>
  <div class="feature">
    <h3>Root Cyclone Technology</h3>
    <p>No clogged bags or filters. Flow efficiencies reduce turbulence and preserve air pressure.</p>
  </div>
  <div class="feature">
    <h3>Simple Emptying</h3>
    <p>Releases dirt into trash easily. Clear bin shows when it needs emptying.</p>
  </div>
</section>

<!-- Image -->
<div class="products-image">
  <img src="images/download.jfif" alt="Products">
</div>

<!-- Company Filter -->
<div class="company-filter">
  <h2>Select Brand </h2>
  <div class="company-logos">
    <?php foreach($companyLogos as $company => $logo): ?>
      <a href="?company=<?= urlencode($company) ?>&sort=<?= $priceSort ?>" 
         class="company-logo <?= ($selectedCompany==$company)?'active':'' ?>">
        <img src="<?= $logo ?>" alt="<?= $company ?>">
      </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- Price Filter -->
<div class="price-filter">
  <label for="price-sort-select">Sort by Price:</label>
  <select id="price-sort-select">
    <option value="default" <?= $priceSort=='default'?'selected':'' ?>>Default</option>
    <option value="low-high" <?= $priceSort=='low-high'?'selected':'' ?>>Low to High</option>
    <option value="high-low" <?= $priceSort=='high-low'?'selected':'' ?>>High to Low</option>
  </select>
</div>

<!-- Products -->
<section class="products">
  <h2>Our Products</h2>
  <div class="product-grid">
    <?php if(count($filteredProducts)==0): ?>
      <p>No products available from <?= $selectedCompany ?>.</p>
    <?php else: ?>
      <?php foreach($filteredProducts as $index => $p): ?>
        <div class="product-card">
          <a href="product.php?id=<?= $index ?>"><img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>"></a>
          <h3><a href="product.php?id=<?= $index ?>"><?= $p['name'] ?></a></h3>
          <p class="price"><?= $p['price'] ?></p>
          <p><small><?= $p['company'] ?></small></p>
          <a href="product.php?id=<?= $index ?>"><button type="button">View Details</button></a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>


<!-- Video Section -->
<section class="video-section">
  <h2>Watch Our Demo</h2>
  <div class="video-container" style="max-width:700px; margin:auto;">
    <video id="demoVideo" controls autoplay loop muted style="width:100%; height:auto; object-fit:contain;">
      <source src="videos/demo.mp4.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
</section>

<script>
  // Unmute audio when the user clicks anywhere
  document.addEventListener("click", function () {
      const video = document.getElementById("demoVideo");
      video.muted = false;
      video.play();
  }, { once: true });
</script>





<!-- Footer -->
<footer>
  <p>&copy; 2025 VacuumAid. All Rights Reserved.</p>
</footer>


<?php if($flashMessage): ?>
<div class="flash-msg" id="flash-msg">
    <?= htmlspecialchars($flashMessage) ?>

</div>
<script>
const flash = document.getElementById('flash-msg');
flash.style.display = 'block';
setTimeout(()=>{ flash.style.display='none'; }, 4000);
</script>
<?php endif; ?>


<!-- WhatsApp + Call Buttons (Fixed at Bottom Right) -->
<div style="position:fixed; bottom:20px; right:20px; display:flex; flex-direction:column; gap:15px; z-index:9999;">

  <!-- WhatsApp Button -->
  <a href="https://wa.me/918999299537?text=Hello%20I%20am%20interested%20in%20your%20products" target="_blank"
     style="display:flex; justify-content:center; align-items:center; width:60px; height:60px; border-radius:50%; background:#25D366; box-shadow:0 4px 6px rgba(0,0,0,0.2); text-decoration:none;">
    <img src="images/watsappap.png" alt="WhatsApp" style="width:40px; height:40px;">
  </a>

  <!-- Call Button -->
  <a href="tel:8999299537"
     onclick="handleCall(event)"
     style="display:flex; justify-content:center; align-items:center; 
            width:60px; height:60px; border-radius:50%; background:#007bff; 
            box-shadow:0 4px 6px rgba(0,0,0,0.2); text-decoration:none;">
    <img src="images/0766d183119ff92920403eb7ae566a85.jpg" 
         alt="Call" style="width:30px; height:30px;">
  </a>

</div>


<script>
function handleCall(event) {
  // Detect if NOT mobile
  if (!/Mobi|Android|iPhone|iPad/i.test(navigator.userAgent)) {
    event.preventDefault(); // stop tel:
    window.location.href = "callto:8999299537"; // fallback for desktop (Skype, etc.)
  }
}
</script>



</div>
<script>
// AI Search Suggestions
const input = document.getElementById('search-input');
const suggestionsBox = document.getElementById('suggestions');
input.addEventListener('input', function() {
  const query = this.value.trim();
  if(query.length === 0){ suggestionsBox.style.display='none'; return; }
  fetch(`?ajax=1&q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
      suggestionsBox.innerHTML='';
      if(data.length===0){ suggestionsBox.style.display='none'; return; }
      data.forEach(item=>{
        const div=document.createElement('div');
        div.textContent=item;
        div.addEventListener('click',()=>{
          input.value=item;
          suggestionsBox.style.display='none';
          document.getElementById('search-form').submit();
        });
        suggestionsBox.appendChild(div);
      });
      suggestionsBox.style.display='block';
    });
});
document.addEventListener('click', function(e){
  if(!input.contains(e.target) && !suggestionsBox.contains(e.target)){ suggestionsBox.style.display='none'; }
});

// Voice Search
const voiceBtn = document.getElementById('voice-btn');
if(voiceBtn){
  voiceBtn.addEventListener('click', ()=>{
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if(!SpeechRecognition){ alert("Your browser doesn't support voice recognition."); return; }
    const recognition = new SpeechRecognition();
    recognition.lang = "en-US";
    recognition.start();
    recognition.onresult = (event)=>{ input.value = event.results[0][0].transcript; document.getElementById('search-form').submit(); };
  });
}

// Camera Upload
document.getElementById('camera-input').addEventListener('change', function(){
  if(this.files.length > 0){
    alert("Image selected: " + this.files[0].name);
  }
});

// Price Filter Change
document.getElementById('price-sort-select').addEventListener('change', function(){
  const sort = this.value;
  const company = '<?= $selectedCompany ?>';
  window.location.href = '?company=' + encodeURIComponent(company) + '&sort=' + encodeURIComponent(sort);
});
</script>



<script>
// Wait until page loads
window.addEventListener('DOMContentLoaded', () => {
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        const name = card.querySelector('h3 a').textContent;
        const priceText = card.querySelector('.price').textContent;
        const price = parseFloat(priceText.replace(/[^0-9.]/g,''));
        const company = card.querySelector('p small').textContent;
        const img = card.querySelector('img').src;

        // Create heart button
        const likeBtn = document.createElement('div');
        likeBtn.className = 'like-btn';
        likeBtn.innerHTML = '🤍'; // empty heart

        // Style heart button
        likeBtn.style.position = 'absolute';
        likeBtn.style.top = '10px';
        likeBtn.style.right = '10px';
        likeBtn.style.fontSize = '1.8rem';
        likeBtn.style.cursor = 'pointer';
        likeBtn.style.userSelect = 'none';

        // Toggle heart on click and save to DB
        likeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if(likeBtn.innerHTML === '🤍'){
                likeBtn.innerHTML = '🤍';'; // filled heart
            } else {
                likeBtn.innerHTML = '🤍';
            }

            fetch('wishlist_add.php', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: `product_name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}&company=${encodeURIComponent(company)}&image=${encodeURIComponent(img)}`
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
            });
        });

        // Position parent relative to place heart
        card.style.position = 'relative';
        card.appendChild(likeBtn);
    });
});
</script>


 
</body>
</html>
