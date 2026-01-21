<?php
session_start();

// Redirect to login if auth_user is not set
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}

// Check for OTP error from previous submission
$flashMessage = '';
if (isset($_SESSION['otp_error'])) {
    $flashMessage = $_SESSION['otp_error'];
    unset($_SESSION['otp_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DROBOTIC</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f3f7fb;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
.container {
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  text-align: center;
  width: 350px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.container h2 {
  margin-bottom: 15px;
}
.otp-inputs {
  display: flex;
  justify-content: space-between;
  margin: 20px 0;
}
.otp-inputs input {
  width: 40px;
  height: 50px;
  font-size: 20px;
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.otp-inputs input:focus {
  border-color: #2874f0;
  outline: none;
  box-shadow: 0 0 5px #2874f0;
}
.verify-btn {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 5px;
  background: #2874f0;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
}
.verify-btn:hover {
  background: #1f5fcc;
}
.resend {
  margin-top: 15px;
  font-size: 0.9rem;
}
.resend a {
  text-decoration: none;
  color: #2874f0;
}
.flash-msg {
  background:#ffdddd;
  color:#a33;
  padding:10px 15px;
  border-radius:6px;
  margin-bottom:15px;
  font-weight:bold;
  text-align:center;
}
</style>
</head>
<body>
<div class="container">
  <h2>Account Verification</h2>
  <p>Enter the 6-digit code sent to <b><?= htmlspecialchars($_SESSION['auth_user']); ?></b></p>

  <?php if($flashMessage): ?>
    <div class="flash-msg"><?= htmlspecialchars($flashMessage) ?></div>
  <?php endif; ?>

  <form id="otp-form" action="verify_process.php" method="POST">
    <div class="otp-inputs">
      <input type="text" name="otp[]" maxlength="1" required>
      <input type="text" name="otp[]" maxlength="1" required>
      <input type="text" name="otp[]" maxlength="1" required>
      <input type="text" name="otp[]" maxlength="1" required>
      <input type="text" name="otp[]" maxlength="1" required>
      <input type="text" name="otp[]" maxlength="1" required>
    </div>
    <button type="submit" class="verify-btn">Verify Code</button>
  </form>

  <div class="resend">
    Didn’t get the code? <a href="resend_otp.php">Resend Code</a>
  </div>
</div>

<script>
// Auto move to next box
const inputs = document.querySelectorAll(".otp-inputs input");
inputs.forEach((input, index) => {
  input.addEventListener("input", () => {
    if (input.value && index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
  });
  input.addEventListener("keydown", (e) => {
    if (e.key === "Backspace" && !input.value && index > 0) {
      inputs[index - 1].focus();
    }
  });
});

// On submit, join all inputs into one hidden field
document.getElementById("otp-form").addEventListener("submit", function(e){
  let otp = "";
  inputs.forEach(i => otp += i.value);
  const hidden = document.createElement("input");
  hidden.type = "hidden";
  hidden.name = "otp_full";
  hidden.value = otp;
  this.appendChild(hidden);
});
</script>
</body>
</html>
