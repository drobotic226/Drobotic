<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $otp = $_POST['otp'];

    // Fix: get email or mobile from session array
    $email_mobile = $_SESSION['auth_user']['email'] ?? $_SESSION['auth_user']['mobile'] ?? '';

    if (!empty($email_mobile)) {
        // Check OTP against DB and expiry time
        $stmt = $conn->prepare("SELECT * FROM users WHERE (email=? OR mobile=?) AND otp=? AND otp_expiry >= NOW()");
        if ($stmt) {
            $stmt->bind_param("sss", $email_mobile, $email_mobile, $otp);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                // ✅ OTP valid
                $_SESSION['loggedin'] = true;

                // Optional: clear OTP after successful verification
                $clear = $conn->prepare("UPDATE users SET otp=NULL, otp_expiry=NULL WHERE email=? OR mobile=?");
                $clear->bind_param("ss", $email_mobile, $email_mobile);
                $clear->execute();

                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Invalid or expired OTP');window.location.href='verify_otp.php';</script>";
            }
        } else {
            die("SQL Error: " . $conn->error);
        }
    } else {
        echo "<script>alert('Session expired. Please login again.');window.location.href='login.php';</script>";
    }
}
?>
