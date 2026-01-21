<?php
// Example: Assume you selected a product and fetched its price from database/cart
$product_price = 1200; // This value will come from DB or session/cart
?>
<!DOCTYPE html>
<html>
<head>
<title>DROBOTIC</title>
<style>
body { font-family: Arial, sans-serif; background:#f7f7f7; padding:20px; }
.container { max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px; }
h2 { text-align:center; }
.upi-option { display:flex; align-items:center; justify-content:space-between; border:1px solid #ddd; padding:10px; margin:10px 0; border-radius:5px; cursor:pointer; }
.upi-option input { margin-right:10px; }
.upi-option img { width:40px; height:40px; }
.submit-btn { background:green; color:#fff; padding:12px; border:none; border-radius:5px; margin-top:15px; width:100%; cursor:pointer; font-size:16px; }
.price-label { font-size:18px; font-weight:bold; margin:15px 0; text-align:center; }
#qrcode { text-align:center; margin-top:20px; }
</style>

<script>
function makePayment(amount) {
    let receiver_upi = "8999145696-2@ibl"; 
    let shopName = "DROBOTIC";
    let note = "Order Payment";

    // Get selected UPI method
    let method = document.querySelector('input[name="pay_method"]:checked')?.value || "Not Selected";

    // Save data in DB (AJAX)
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "save_payment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("method=" + encodeURIComponent(method) + "&amount=" + amount);

    // Create UPI payment URL
    let upiUrl = "upi://pay?pa=" + receiver_upi 
               + "&pn=" + encodeURIComponent(shopName) 
               + "&am=" + amount 
               + "&cu=INR&tn=" + encodeURIComponent(note);

    // Detect device
    let isMobile = /Mobi|Android/i.test(navigator.userAgent);

    if (isMobile) {
        // On mobile → open UPI app
        window.location.href = upiUrl;
    } else {
        // On desktop → show QR code
        document.getElementById("qrcode").innerHTML =
            "<h3>Scan & Pay</h3><img src='https://api.qrserver.com/v1/create-qr-code/?data=" 
            + encodeURIComponent(upiUrl) + "&size=200x200' alt='UPI QR Code'>";
    }
}
</script>
</head>

<body>
<div class="container">
    <h2>Select UPI App</h2>

    <!-- ✅ Show Dynamic Price -->
    <div class="price-label">Total Price: ₹<?php echo $product_price; ?></div>

    <!-- UPI Options -->
    <label class="upi-option">
        <span><input type="radio" name="pay_method" value="Google Pay" required> Google Pay</span>
        <img src="images/5232468.png" alt="Google Pay">
    </label>
    <label class="upi-option">
        <span><input type="radio" name="pay_method" value="PhonePe"> PhonePe</span>
        <img src="images/PROD-aa944068-e222-41c1-83a1-4cf50c14444e.png" alt="PhonePe">
    </label>
    <label class="upi-option">
        <span><input type="radio" name="pay_method" value="PayTM"> PayTM</span>
        <img src="images/unnamed.png" alt="PayTM">
    </label>
    <label class="upi-option">
        <span><input type="radio" name="pay_method" value="Other UPI"> Other UPI</span>
        <img src="images/upi-twitter.webp" alt="UPI">
    </label>

    <!-- Proceed Button -->
    <button type="button" class="submit-btn" onclick="makePayment(<?php echo $product_price; ?>)">Proceed to Pay</button>

    <!-- QR Code will show here if desktop -->
    <div id="qrcode"></div>
</div>
</body>
</html>
