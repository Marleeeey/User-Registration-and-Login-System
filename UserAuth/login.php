<?php
    session_start();
    require "db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        //PREPARE THE BIND
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();


        //CHECK THE CONNECTION
        if ($user && password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $_SESSION['error'] = "Invalid username or password!";
        }
        $stmt->close();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIGN</title>
  <link rel="stylesheet" href="styles.css" />
  <!-- Font Awesome CDN link for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body>
  <div class="wrapper">
    <div class="title"><span>Sign Form</span></div>
    <form action="" method = "POST">
      <div class="row">
        <i class="fas fa-user"></i>
        <input type="email" placeholder="Email or Phone" name = "username" required />
      </div>
      <div class="row">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" name = "password" required />
      </div>
      <?php if (isset($_SESSION['error'])): ?>
        <p id="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
      <div class="row button">
        <input type="submit" value="Login" />
      </div>
      <div class="signup-link">Not a member? <a href="register.php">Register now</a></div>
    </form>
  </div>
</body>
</html>