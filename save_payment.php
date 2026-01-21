<?php
// Database connection
$host = "localhost";
$user = "root";    // change if needed
$pass = "";        // change if needed
$dbname = "drobotic_db";  // your database name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Collect values
$method = $_POST['method'] ?? "Unknown";
$amount = $_POST['amount'] ?? 0;

// Generate OTP & expiry
$otp = rand(100000, 999999);
$otp_expiry = date("Y-m-d H:i:s", strtotime("+1 minutes"));

// Insert into payments table
$sql = "INSERT INTO payments (name, email, mobile, amount, upi_txn_id, status, otp, otp_expiry) 
        VALUES ('Guest User', NULL, NULL, ?, ?, 'pending', ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $amount, $method, $otp, $otp_expiry);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
