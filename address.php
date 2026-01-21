<?php
session_start();

/* -------------------------------
   Initialize address list
-------------------------------- */
if (!isset($_SESSION['addresses'])) {
    $_SESSION['addresses'] = [];
}

/* -------------------------------
   ADD NEW ADDRESS
-------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_address'])) {

    $newAddress = [
        "name"    => $_POST['name'],
        "phone"   => $_POST['phone'],
        "address" => $_POST['address'],
        "city"    => $_POST['city'],
        "pincode" => $_POST['pincode']
    ];

    // Save address
    $_SESSION['addresses'][] = $newAddress;

    // Auto select this address
    $_SESSION['selected_address'] = $newAddress;

    // Ensure cart exists
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $_SESSION['cart'] = [
            ["id" => 0, "quantity" => 2],
            ["id" => 3, "quantity" => 1]
        ];
    }

    // Redirect to payment
    header("Location: payment.php");
    exit;
}

/* -------------------------------
   CHOOSE SAVED ADDRESS
-------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choose_address'])) {

    $selectedIndex = $_POST['selected_address'] ?? null;

    if ($selectedIndex !== null && isset($_SESSION['addresses'][$selectedIndex])) {

        $_SESSION['selected_address'] = $_SESSION['addresses'][$selectedIndex];

        // Ensure cart exists
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['cart'] = [
                ["id" => 0, "quantity" => 2],
                ["id" => 3, "quantity" => 1]
            ];
        }

        header("Location: payment.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Drobotic - Address</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body { font-family: Arial, sans-serif; background:#f7f7f7; margin:0; padding:20px; }
.container { max-width:900px; margin:120px auto; background:#fff; padding:20px; border-radius:8px; }
h2 { margin-bottom:15px; }
form { margin-bottom:30px; }
input, textarea { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:5px; }
button { background:purple; color:#fff; padding:10px 16px; border:none; border-radius:5px; cursor:pointer; }
button:hover { background:darkviolet; }
.add-btn { background:green; }
.add-btn:hover { background:darkgreen; }
.address-list { margin-top:20px; }
.address-item { border:1px solid #ccc; padding:15px; border-radius:5px; margin-bottom:10px; background:#fafafa; }
.hidden { display:none; }
</style>
</head>

<body>

<div class="container">

<?php if (!empty($_SESSION['addresses'])): ?>

    <!-- SAVED ADDRESSES -->
    <h2>Choose Delivery Address</h2>

    <form method="post">
        <div class="address-list">
            <?php foreach ($_SESSION['addresses'] as $index => $addr): ?>
                <div class="address-item">
                    <label>
                        <input type="radio" name="selected_address" value="<?= $index ?>" required>
                        <b><?= htmlspecialchars($addr['name']) ?></b> - <?= htmlspecialchars($addr['phone']) ?><br>
                        <?= htmlspecialchars($addr['address']) ?>,
                        <?= htmlspecialchars($addr['city']) ?> - <?= htmlspecialchars($addr['pincode']) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" name="choose_address">Next</button>
    </form>

    <!-- ADD NEW ADDRESS BUTTON -->
    <button class="add-btn"
        onclick="document.getElementById('newAddressForm').classList.toggle('hidden')">
        + Add New Address
    </button>

<?php endif; ?>

<!-- ADD NEW ADDRESS FORM -->
<div id="newAddressForm" class="<?= !empty($_SESSION['addresses']) ? 'hidden' : '' ?>">

    <h2>Add New Address</h2>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <textarea name="address" placeholder="Full Address" required></textarea>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="pincode" placeholder="Pincode" required>
        <button type="submit" name="add_address">Save Address</button>
    </form>

</div>

</div>

</body>
</html>
