<?php
include "db.php"; // DB connection

// ======================================
// AUTO GENERATE CUSTOMER ID
// ======================================
mysqli_query($conn, "INSERT INTO customer_sequence VALUES (NULL)");
$lastId = mysqli_insert_id($conn);

$customerId = "DRB-CUST-2025-" . str_pad($lastId, 4, "0", STR_PAD_LEFT);


// ======================================
// ORDER FIELDS (POST VALUES)
// ======================================
$email       = $_POST['email'];
$mobile      = $_POST['mobile'];
$product     = $_POST['product_name'];
$quantity    = $_POST['quantity'];
$price       = $_POST['price'];
$company     = $_POST['company'];
$status      = "Pending";
$orderDate   = date("Y-m-d H:i:s");


// ======================================
// INSERT ORDER INTO drobotic_db → orders TABLE
// ======================================
$sql = "INSERT INTO orders 
        (customer_id, email, mobile, product_name, quantity, price, company, status, order_date)
        VALUES 
        ('$customerId', '$email', '$mobile', '$product', '$quantity', '$price', '$company', '$status', '$orderDate')";

if (mysqli_query($conn, $sql)) {
    echo "Order Saved Successfully! Customer ID: $customerId";
} else {
    echo "Error: " . mysqli_error($conn);
}

?>
