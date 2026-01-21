<?php
session_start();

// Check if OTP session exists
if (!isset($_SESSION['otp']) || !isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp_full'] ?? '';

    // Remove any non-digit characters (just in case)
    $enteredOtp = preg_replace('/\D/', '', $enteredOtp);

    // Compare with session OTP
    if ($enteredOtp == $_SESSION['otp']) {
        // OTP verified successfully
        // Clear OTP from session
        unset($_SESSION['otp']);

        // You can set user as logged in
        $_SESSION['user_logged_in'] = true;

        // Redirect to dashboard or success page
        header("Location: success.php");
        exit;
    } else {
        // OTP failed
        $_SESSION['otp_error'] = "Invalid OTP. Please try again.";
        header("Location: verify_otp.php");
        exit;
    }
}
?>
