<?php
session_start();
include("db.php"); // include DB connection

$flashMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $flashMessage = "Please enter both Username and Password.";
    } else {

        // SQL Query
        $query = "SELECT id, username, password FROM users WHERE username=? LIMIT 1";
        $stmt = $conn->prepare($query);

        // ---- FIX ERROR HERE ----
        // If prepare fails → show real SQL error
        if (!$stmt) {
            die("<b>SQL ERROR:</b> " . $conn->error . "<br><b>QUERY:</b> $query");
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $stmt->bind_result($id, $db_user, $db_pass);
            $stmt->fetch();

            // Password match (plain text)
            if ($password === $db_pass) {

                $_SESSION['admin_id'] = $id;
                $_SESSION['admin_username'] = $db_user;

                header("Location: admin_dashboard.php");
                exit;

            } else {
                $flashMessage = "Incorrect Password.";
            }

        } else {
            $flashMessage = "Username not found.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DROBOTIC</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Roboto', sans-serif; }
body, html { height:100%; background:#f5f5f5; }

.container { display: flex; min-height: 100vh; justify-content: center; align-items: center; }

.login-card { 
    display: flex; 
    width: 900px; 
    height: 500px; 
    box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
    border-radius: 8px; 
    overflow: hidden; 
    background: #fff; 
}

/* Left Panel with Purple Background */
.left-panel {
    flex: 1;
    background: linear-gradient(135deg, #6a0dad, #9b30ff);
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    text-align: center;
}
.left-panel h1 { font-size: 2rem; margin-bottom: 15px; }
.left-panel p { font-size: 1rem; margin-bottom: 20px; }
.left-panel img { max-width: 200px; margin-top: 20px; }

/* Right Panel */
.right-panel {
    flex: 1;
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.right-panel h2 { margin-bottom: 20px; color: #333; font-size: 1.5rem; }

.input-group { display: flex; flex-direction: column; margin-bottom: 20px; }
.input-group label { font-size: 0.9rem; margin-bottom: 5px; color: #555; }
.input-group input { padding: 12px 15px; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; outline: none; }
.input-group input:focus { border-color: #2874f0; }

.login-btn { 
    padding: 12px; 
    background: #fb641b; 
    border: none; 
    color: #fff; 
    font-size: 1rem; 
    font-weight: 500; 
    border-radius: 4px; 
    cursor: pointer; 
    margin-top: 10px; 
}
.login-btn:hover { background: #e55a16; }

.flash-msg { background:#ffdd57; color:#000; padding:12px 20px; border-radius:8px; font-weight:bold; margin-bottom:15px; text-align:center; }

.right-panel .note { font-size: 0.8rem; color: #777; margin-top: 10px; }

.right-panel .register { margin-top: auto; font-size: 0.9rem; text-align: center; }
.right-panel .register a { color: #2874f0; text-decoration: none; }
.right-panel .register a:hover { text-decoration: underline; }

@media(max-width:900px){
    .login-card { flex-direction: column; height: auto; }
    .left-panel, .right-panel { flex: none; width: 100%; padding: 40px 20px; }
    .left-panel img { max-width: 150px; }
}
</style>

</head>

<body>

<div class="container">
  <div class="login-card">

    <!-- Left Panel -->
    <div class="left-panel">
      <h1>Login</h1>
      <p>Enter your credentials to securely access the admin dashboard.</p>
      <img src="images/Screenshot 2025-12-05 121957.png" alt="Login Image">
    </div>

    <!-- Right Panel -->
    <div class="right-panel">

      <h2>Admin Login</h2>

      <?php if($flashMessage): ?>
        <div class="flash-msg"><?= htmlspecialchars($flashMessage) ?></div>
      <?php endif; ?>

      <form action="" method="POST">

        <div class="input-group">
          <label for="username">Enter Username</label>
          <input type="text" name="username" id="username" placeholder="Enter Username" required>
        </div>

        <div class="input-group">
          <label for="password">Enter Password</label>
          <input type="password" name="password" id="password" placeholder="Enter Password" required>
        </div>

        <button type="submit" class="login-btn">Login</button>

      </form>

      <div class="register">
        New to DROBOTIC? <a href="register.php">Create an account</a>
      </div>

    </div>

  </div>
</div>

</body>
</html>
